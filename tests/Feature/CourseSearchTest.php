<?php

namespace Tests\Feature;

use App\Models\Course;
use Database\Seeders\CourseDiscoverySeeder;
use Database\Seeders\CourseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseSearchTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(CourseSeeder::class);
        $this->seed(CourseDiscoverySeeder::class);
    }

    public function test_data_dummy_cukup_untuk_pengujian(): void
    {
        $this->assertSame(32, Course::count());
        $this->assertSame(19, Course::where('status', 'open')->count());
        $this->assertGreaterThan(0, Course::where('status', 'closed')->count());
        $this->assertGreaterThan(0, Course::where('status', 'draft')->count());
    }

    public function test_skenario_1_nol_hasil_menampilkan_empty_state(): void
    {
        $this->get('/courses?q=tidak-ada-xyz-999')
            ->assertOk()
            ->assertSee('Tidak ada kursus yang sesuai pencarian/filter.')
            ->assertSee('0 kursus ditemukan');
    }

    public function test_skenario_2_satu_hasil(): void
    {
        $response = $this->get('/courses?q=UNQ-777')->assertOk();

        $this->assertSame(1, $response->viewData('courses')->total());
        $response->assertSee('Kriptografi Terapan');
    }

    public function test_skenario_3_lebih_dari_sepuluh_hasil_dipaginasi(): void
    {
        $response = $this->get('/courses?status=open')->assertOk();
        $courses = $response->viewData('courses');

        $this->assertSame(19, $courses->total());
        $this->assertCount(10, $courses->items());
        $response->assertSee('status=open&amp;page=2', false);
    }

    public function test_skenario_4_keyword_dengan_spasi(): void
    {
        $this->get('/courses?q='.urlencode('Web Modern'))
            ->assertOk()
            ->assertSee('Web Modern Dasar')
            ->assertSee('Web Modern Lanjut')
            ->assertDontSee('Laravel Dasar');
    }

    public function test_keyword_dengan_spasi_di_pinggir_dipangkas(): void
    {
        $response = $this->get('/courses?q='.urlencode('  laravel dasar  '))->assertOk();

        $this->assertSame('laravel dasar', $response->viewData('search'));
        $response->assertSee('Laravel Dasar');
    }

    public function test_skenario_5_filter_dan_halaman_dua_menjaga_query(): void
    {
        $response = $this->get('/courses?status=open&page=2')->assertOk();
        $courses = $response->viewData('courses');

        $this->assertSame(2, $courses->currentPage());
        $this->assertCount(9, $courses->items());
        $this->assertTrue($courses->every(fn ($c) => $c->status === 'open'));
        $response->assertSee('status=open&amp;page=1', false);
    }

    public function test_search_berdasarkan_code(): void
    {
        $this->get('/courses?q=LRV-101')->assertOk()->assertSee('Laravel Dasar');
    }

    public function test_filter_status_tidak_valid_diabaikan(): void
    {
        $response = $this->get('/courses?status=hacker')->assertOk();

        $this->assertSame(32, $response->viewData('courses')->total());
    }

    public function test_status_kosong_tidak_membuat_hasil_nol(): void
    {
        $response = $this->get('/courses?q=&status=')->assertOk();

        $this->assertSame(32, $response->viewData('courses')->total());
    }

    public function test_partial_hanya_mengembalikan_blok_hasil_tanpa_layout(): void
    {
        $this->get('/courses?status=open&partial=1')
            ->assertOk()
            ->assertSee('id="course-results"', false)
            ->assertDontSee('<html', false)
            ->assertDontSee('partial=1', false);
    }

    public function test_halaman_penuh_memuat_form_get_dan_dashboard_count(): void
    {
        $response = $this->get('/courses')->assertOk();

        $response->assertSee('method="GET"', false)
            ->assertSee('Total kursus')
            ->assertSee('<html', false);

        $this->assertSame(32, $response->viewData('stats')['total']);
        $this->assertSame(19, $response->viewData('stats')['open']);
    }
}
