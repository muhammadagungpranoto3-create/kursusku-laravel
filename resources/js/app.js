import './bootstrap';
import 'bootstrap';
import $ from 'jquery';

window.$ = window.jQuery = $;

$(document).on('change', '#course_id', function () {
    const id = this.value;

    if (!id) {
        $('#availability')
            .removeClass('alert-success alert-danger')
            .addClass('alert-secondary')
            .text('Pilih kursus untuk melihat kuota dan status.');
        return;
    }

    $('#availability')
        .removeClass('alert-success alert-danger')
        .addClass('alert-secondary')
        .text('Memuat ketersediaan...');

    $.ajax({
        url: `/courses/${id}/availability`,
        method: 'GET',
        dataType: 'json',
        success(data) {
            const label = { draft: 'Draft', open: 'Open', closed: 'Closed' }[data.status] || data.status;
            $('#availability')
                .removeClass('alert-secondary alert-danger')
                .addClass('alert-success')
                .text(`${data.code} — ${data.name}. Kuota ${data.quota}. Status ${label}.`);
        },
        error() {
            $('#availability')
                .removeClass('alert-secondary alert-success')
                .addClass('alert-danger')
                .text('Gagal memuat ketersediaan kursus.');
        }
    });
});
