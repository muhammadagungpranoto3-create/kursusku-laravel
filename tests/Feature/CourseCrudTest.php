<?php

namespace Tests\Feature;

use App\Models\Course;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseCrudTest extends TestCase
{
    use RefreshDatabase;

    private function validData(array $override = []): array
    {
        return array_merge([
            'code' => 'TST-001',
            'name' => 'Kursus Uji',
            'description' => 'Data dummy pengujian.',
            'fee' => 100000,
            'quota' => 20,
            'start_date' => '2026-12-01',
            'status' => 'open',
        ], $override);
    }

    private function makeCourse(string $code = 'WEB-001'): Course
    {
        return Course::create($this->validData(['code' => $code]));
    }

    public function test_show_menampilkan_detail_dan_404_jika_tidak_ada(): void
    {
        $course = $this->makeCourse();

        $this->get(route('courses.show', $course))->assertOk()->assertSee('WEB-001');
        $this->get('/courses/999999')->assertNotFound();
    }

    public function test_store_valid_dan_kasus_batas_kuota(): void
    {
        $this->post(route('courses.store'), $this->validData(['code' => 'Q-1', 'quota' => 1]))
            ->assertRedirect(route('courses.index'));
        $this->post(route('courses.store'), $this->validData(['code' => 'Q-500', 'quota' => 500]))
            ->assertRedirect(route('courses.index'));

        $this->assertDatabaseHas('courses', ['code' => 'Q-1']);
        $this->assertDatabaseHas('courses', ['code' => 'Q-500']);
    }

    public function test_store_menolak_data_tidak_valid(): void
    {
        $this->makeCourse('DUP-001');

        $cases = [
            ['code' => 'DUP-001'],          // 1 duplicate code
            ['name' => ''],                 // 2 nama kosong
            ['name' => 'AI'],               // 3 nama terlalu pendek
            ['fee' => -1000],               // 4 fee negatif
            ['fee' => 'abc'],               // 5 fee bukan integer
            ['quota' => 0],                 // 6 quota 0
            ['quota' => 501],               // 7 quota 501
            ['start_date' => 'bukan-tanggal'], // 10 tanggal invalid
            ['status' => 'active'],         // 11 status invalid
        ];

        foreach ($cases as $override) {
            $field = array_key_first($override);
            $this->from(route('courses.create'))
                ->post(route('courses.store'), $this->validData(array_merge(['code' => 'NEW-'.uniqid()], $override)))
                ->assertSessionHasErrors($field);
        }
    }

    public function test_update_dengan_code_sendiri_berhasil(): void
    {
        $course = $this->makeCourse('WEB-001');

        $this->put(route('courses.update', $course), $this->validData(['code' => 'WEB-001', 'name' => 'Nama Baru']))
            ->assertRedirect(route('courses.show', $course))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('courses', ['id' => $course->id, 'name' => 'Nama Baru']);
    }

    public function test_update_ke_code_course_lain_ditolak(): void
    {
        $a = $this->makeCourse('AAA-001');
        $this->makeCourse('BBB-001');

        $this->put(route('courses.update', $a), $this->validData(['code' => 'BBB-001']))
            ->assertSessionHasErrors('code');
    }

    public function test_destroy_menghapus_course(): void
    {
        $course = $this->makeCourse('DEL-001');

        $this->delete(route('courses.destroy', $course))
            ->assertRedirect(route('courses.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    }
}
