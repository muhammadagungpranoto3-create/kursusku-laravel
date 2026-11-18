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
