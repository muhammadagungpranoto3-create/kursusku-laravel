<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Participant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnrollmentTest extends TestCase
{
    use RefreshDatabase;

    private function makeCourse(string $code = 'LRV-T1', array $override = []): Course
    {
        return Course::create(array_merge([
            'code' => $code,
            'name' => 'Laravel Uji '.$code,
            'description' => 'Data dummy pengujian.',
            'fee' => 100000,
            'quota' => 5,
            'start_date' => '2026-12-01',
            'status' => 'open',
        ], $override));
    }

    private function makeParticipant(string $name = 'Alya Rahma', string $email = 'alya@example.test'): Participant
    {
        return Participant::create(['name' => $name, 'email' => $email]);
    }

    private function enroll(Participant $participant, Course $course)
    {
        return $this->from(route('enrollments.create'))
            ->post(route('enrollments.store'), [
                'participant_id' => $participant->id,
                'course_id' => $course->id,
            ]);
    }

    public function test_form_hanya_menampilkan_course_open(): void
    {
        $this->makeParticipant();
        $this->makeCourse('OPEN-1');
        $this->makeCourse('DRAFT-1', ['status' => 'draft']);

        $this->get(route('enrollments.create'))
            ->assertOk()
            ->assertSee('Alya Rahma')
            ->assertSee('OPEN-1')
            ->assertDontSee('DRAFT-1');
    }

    public function test_enrollment_valid_tersimpan_dengan_status_registered(): void
    {
        $participant = $this->makeParticipant();
        $course = $this->makeCourse();

        $this->enroll($participant, $course)
            ->assertRedirect(route('enrollments.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('enrollments', [
            'participant_id' => $participant->id,
            'course_id' => $course->id,
            'status' => 'registered',
        ]);
    }

    public function test_field_kosong_ditolak(): void
    {
        $this->from(route('enrollments.create'))
            ->post(route('enrollments.store'), [])
            ->assertSessionHasErrors(['participant_id', 'course_id']);

        $this->assertDatabaseCount('enrollments', 0);
    }

    public function test_pendaftaran_ganda_ditolak_tetapi_kombinasi_lain_boleh(): void
    {
        $alya = $this->makeParticipant();
        $bima = $this->makeParticipant('Bima Putra', 'bima@example.test');
        $laravel = $this->makeCourse('LRV-T1');
        $php = $this->makeCourse('PHP-T1');

        $this->enroll($alya, $laravel)->assertSessionHasNoErrors();

        // Alya -> Laravel lagi: ditolak
        $this->enroll($alya, $laravel)->assertSessionHasErrors('course_id');

        // Alya -> PHP dan Bima -> Laravel: boleh
        $this->enroll($alya, $php)->assertSessionHasNoErrors();
        $this->enroll($bima, $laravel)->assertSessionHasNoErrors();

        $this->assertDatabaseCount('enrollments', 3);
    }

    public function test_course_draft_atau_closed_ditolak(): void
    {
        $participant = $this->makeParticipant();

        $this->enroll($participant, $this->makeCourse('DRF-1', ['status' => 'draft']))
            ->assertSessionHasErrors('course_id');
        $this->enroll($participant, $this->makeCourse('CLS-1', ['status' => 'closed']))
            ->assertSessionHasErrors('course_id');

        $this->assertDatabaseCount('enrollments', 0);
    }

    public function test_kuota_penuh_ditolak(): void
    {
        $course = $this->makeCourse('FULL-1', ['quota' => 1]);
        $first = $this->makeParticipant();
        $second = $this->makeParticipant('Bima Putra', 'bima@example.test');

        $this->enroll($first, $course)->assertSessionHasNoErrors();
        $this->enroll($second, $course)->assertSessionHasErrors('course_id');

        $this->assertDatabaseCount('enrollments', 1);
    }

    public function test_laporan_menampilkan_data_lintas_tabel(): void
    {
        $participant = $this->makeParticipant();
        $course = $this->makeCourse('RPT-1');
        Enrollment::create(['participant_id' => $participant->id, 'course_id' => $course->id, 'status' => 'registered']);

        $this->get(route('enrollments.index'))
            ->assertOk()
            ->assertSee('Alya Rahma')
            ->assertSee('Laravel Uji RPT-1')
            ->assertSee('Terdaftar');
    }

    public function test_laporan_kosong_menampilkan_pesan(): void
    {
        $this->get(route('enrollments.index'))
            ->assertOk()
            ->assertSee('Belum ada enrollment.');
    }

    public function test_relasi_eloquent(): void
    {
        $participant = $this->makeParticipant();
        $course = $this->makeCourse();
        $enrollment = Enrollment::create(['participant_id' => $participant->id, 'course_id' => $course->id]);

        $this->assertSame('registered', $enrollment->fresh()->status);
        $this->assertTrue($enrollment->participant->is($participant));
        $this->assertTrue($enrollment->course->is($course));
        $this->assertCount(1, $participant->enrollments);
        $this->assertCount(1, $course->enrollments);
        $this->assertTrue($participant->courses->first()->is($course));
        $this->assertTrue($course->participants->first()->is($participant));
    }

    public function test_cascade_hapus_course_tidak_menghapus_participant(): void
    {
        $participant = $this->makeParticipant();
        $course = $this->makeCourse('CAS-C');
        Enrollment::create(['participant_id' => $participant->id, 'course_id' => $course->id]);

        $course->delete();

        $this->assertSame(0, Enrollment::where('course_id', $course->id)->count());
        $this->assertNotNull(Participant::find($participant->id));
    }

    public function test_cascade_hapus_participant_tidak_menghapus_course(): void
    {
        $participant = $this->makeParticipant();
        $course = $this->makeCourse('CAS-P');
        Enrollment::create(['participant_id' => $participant->id, 'course_id' => $course->id]);

        $participant->delete();

        $this->assertSame(0, Enrollment::where('participant_id', $participant->id)->count());
        $this->assertNotNull(Course::find($course->id));
    }

    public function test_endpoint_availability_mengembalikan_sisa_kursi(): void
    {
        $course = $this->makeCourse('AVL-1', ['quota' => 3]);
        Enrollment::create(['participant_id' => $this->makeParticipant()->id, 'course_id' => $course->id]);

        $this->getJson(route('courses.availability', $course))
            ->assertOk()
            ->assertJson([
                'code' => 'AVL-1',
                'quota' => 3,
                'enrolled' => 1,
                'remaining' => 2,
                'status' => 'open',
            ]);
    }

    public function test_alamat_lama_pendaftaran_dialihkan(): void
    {
        $this->get('/pendaftaran')->assertRedirect('/enrollments/create');
    }
}
