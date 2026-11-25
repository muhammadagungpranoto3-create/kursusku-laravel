import './bootstrap';
import 'bootstrap';
import $ from 'jquery';

window.$ = window.jQuery = $;

/* ------------------------------------------------------------
   Form enrollment: kartu tiket diperbarui lewat Ajax.
   Endpoint: GET /courses/{id}/availability (EnrollmentController@availability)
   ------------------------------------------------------------ */
const STATUS_LABEL = { draft: 'Draft', open: 'Dibuka', closed: 'Ditutup' };

function rupiah(value) {
    return 'Rp ' + Number(value).toLocaleString('id-ID');
}

function setMeter(percent, state) {
    $('#ticket-meter')
        .removeClass('ok low full')
        .addClass(state)
        .find('.kk-meter-bar span')
        .css('width', percent + '%');
}

function resetTicket() {
    $('#ticket').addClass('is-empty');
    $('#ticket-code').text('Belum dipilih');
    $('#ticket-name').text('Pilih kursus untuk melihat tiketnya');
    $('#ticket-desc').text('Jadwal mulai, biaya, dan sisa kursi akan tampil di sini.');
    $('#ticket-date, #ticket-fee, #ticket-status').text('-');
    $('#ticket-seats').text('Sisa kursi tampil setelah kursus dipilih.');
    setMeter(0, 'ok');
}

function renderTicket(data) {
    const percent = Math.min(100, Math.round((data.enrolled / Math.max(1, data.quota)) * 100));
    const state = data.remaining === 0 ? 'full' : percent >= 70 ? 'low' : 'ok';

    $('#ticket').removeClass('is-empty');
    $('#ticket-code').text(data.code);
    $('#ticket-name').text(data.name);
    $('#ticket-desc').text(data.description || 'Belum ada deskripsi kursus.');
    $('#ticket-date').text(data.start_label);
    $('#ticket-fee').text(rupiah(data.fee));
    $('#ticket-status').text(STATUS_LABEL[data.status] || data.status);
    $('#ticket-seats').text(
        data.remaining === 0
            ? `${data.enrolled} dari ${data.quota} kursi terisi, penuh`
            : `${data.enrolled} dari ${data.quota} kursi terisi, sisa ${data.remaining}`
    );
    setMeter(percent, state);
}

$(document).on('change', '#course_id', function () {
    const id = this.value;

    if (!id) {
        resetTicket();
        return;
    }

    $('#ticket-seats').text('Memuat ketersediaan...');

    $.ajax({
        url: `/courses/${id}/availability`,
        method: 'GET',
        dataType: 'json',
        success: renderTicket,
        error() {
            $('#ticket-seats').text('Gagal memuat ketersediaan kursus.');
        },
    });
});

$(document).on('change', '#participant_id', function () {
    const name = $(this).find('option:selected').data('name');
    $('#ticket-participant').text(name || '-');
});

// Nilai awal (old input setelah validasi gagal, atau ?course=ID).
$(function () {
    if ($('#ticket').length) {
        $('#participant_id').trigger('change');
        $('#course_id').trigger('change');
    }
});

/* ------------------------------------------------------------
   Pertemuan 13 - live search + filter + pagination (Ajax opsional)
   Form GET di halaman tetap menjadi fallback tanpa JavaScript.
   ------------------------------------------------------------ */
let searchTimer;
let currentRequest = null;

function loadCourses(url) {
    const $form = $('#course-filter');
    if (!$form.length) return;

    const target = url || $form.attr('action');
    const params = { q: $('#live-search').val(), status: $('#status-filter').val() };

    if (currentRequest) currentRequest.abort(); // buang respons lama yang belum selesai

    $('#course-error').prop('hidden', true);
    $('#course-results').addClass('is-loading');

    currentRequest = $.get(target, { ...params, partial: 1 })
        .done(function (html) {
            $('#course-results').replaceWith(html);

            // Alamat di browser tetap bisa disalin: tanpa parameter partial.
            const page = new URL(target, window.location.origin).searchParams.get('page');
            const query = new URLSearchParams();
            if (params.q) query.set('q', params.q);
            if (params.status) query.set('status', params.status);
            if (page) query.set('page', page);
            const qs = query.toString();
            history.replaceState(null, '', $form.attr('action') + (qs ? `?${qs}` : ''));
        })
        .fail(function (xhr) {
            if (xhr.statusText === 'abort') return;
            $('#course-results').removeClass('is-loading');
            $('#course-error').prop('hidden', false);
            console.error('Gagal memuat hasil course.');
        });
}

// Debounce 300 ms: request dikirim setelah pengguna berhenti mengetik.
$(document).on('input', '#live-search', function () {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => loadCourses(), 300);
});

$(document).on('change', '#status-filter', function () {
    loadCourses();
});

// Pagination lewat Ajax (delegated, karena #course-results diganti setiap kali).
$(document).on('click', '#course-results .pagination a', function (e) {
    e.preventDefault();
    loadCourses($(this).attr('href'));
});
