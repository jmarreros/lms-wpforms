(function ($) {
    'use strict';

    // Save configuration fields
    $('#btn-save-fields').click(function (e) {
        e.preventDefault();

        let fields = [];
        $('#table-fields tbody tr.changed').each(function (index, element) {
            const id = $(element).attr('id');
            const label = $(element).find('.label').text();
            const type = $(element).find('.type').text();
            const options = $(element).find('.options').text();
            const document = $(element).find('.document').val();
            const order = $(element).find('.order').val();

            fields.push({
                id: id, label: label, type: type, options: options, document: document, order: order
            });
        });

        $.ajax({
            url: lms_forms.ajaxurl,
            type: 'post',
            dataType: 'json',
            data: {
                action: 'dcms_lms_forms_save_fields',
                nonce: lms_forms.nonce_lms_forms,
                fields: fields
            }, beforeSend: function () {
                $('#container-fields .msg-btn').text(lms_forms.sending);
                $('#container-fields .button').prop('disabled', true);
                $('#container-fields .loading').removeClass('hide');
            }
        })
            .done(function (res) {
                $('#container-fields .msg-btn').text(res.message);
            })
            .always(function () {
                $('#container-fields .button').prop('disabled', false);
                $('#container-fields .loading').addClass('hide');
            });
    });

    // Mark as changed when input or select changes
    $('#table-fields tr select, #table-fields tr input').on('change', function () {
        $(this).closest('tr').addClass('changed');
    });


    $('#search-courses').click(function (e) {
        e.preventDefault();

        $.ajax({
            url: lms_forms.ajaxurl,
            type: 'post',
            dataType: 'json',
            data: {
                action: 'dcms_lms_search_courses',
                dateFrom: $('#date-from').val(),
                dateTo: $('#date-to').val(),
                nonce: lms_forms.nonce_lms_forms,
            }, beforeSend: function () {
                $('#container-report input').prop('disabled', true);
                $('#container-report select').prop('disabled', true);
                $('#container-report .dates-loading').removeClass('hide');
            }
        })
            .done(function (res) {
                // clear list-courses
                $('#list-courses').html('<option value="0">Seleccione un curso</option>');

                if ( res.data.length === 0 ) {
                    alert('No hay cursos en el rango de fechas seleccionado');
                    return;
                }

                // fill list-courses
                res.data.forEach(function (item) {
                    $('#list-courses').append('<option value="' + item.course_id + '">' + item.course_name + '</option>');
                });
            })
            .always(function () {
                $('#container-report input').prop('disabled', false);
                $('#container-report select').prop('disabled', false);
                $('#container-report .dates-loading').addClass('hide');
            });

    });


    // For filtering, reporting screen
    $('#search-entries').click(function (e) {
        e.preventDefault();

        //clean data
        $('#table-entries-report tbody').html('');
        $('#course_name').text('');
        $('#course_author').text('');
        $('.documents a').hide();


        const course = parseInt($('#list-courses').val());

        if (course === 0) {
            alert('Seleccione un curso');
            return;
        }


        $.ajax({
            url: lms_forms.ajaxurl,
            type: 'post',
            dataType: 'json',
            data: {
                action: 'dcms_lms_search_entries',
                course: course,
                nonce: lms_forms.nonce_lms_forms,
            }, beforeSend: function () {
                $('#container-report input').prop('disabled', true);
                $('#container-report select').prop('disabled', true);
                $('#container-report .course-loading').removeClass('hide');
            }
        })
            .done(function (res) {
                if (res.message === 'success') {

                    let r = Array();
                    let j = -1;

                    $('#course_name').text(res.data[0].course_name ?? '');
                    $('#course_author').text(res.data[0].author_name ?? '');

                    for (let i = 0; i < res.data.length; i++) {

                        const entry_url = lms_forms.entries_url + res.data[i].entry_id_wpforms;
                        r[++j] = "<tr><td>";
                        r[++j] = res.data[i].user_name;
                        r[++j] = "</td><td>";
                        r[++j] = res.data[i].updated;
                        r[++j] = "</td><td>";
                        r[++j] = "<a href='" + entry_url + "' target='_blank'>Ver</a>";
                        r[++j] = "</td></tr>";
                    }

                    $('#table-entries-report tbody').html(r.join(''));
                    if (r.length > 0) {
                        $('.documents a').show();
                    }
                }
            })
            .always(function () {
                $('#container-report input').prop('disabled', false);
                $('#container-report select').prop('disabled', false);
                $('#container-report .course-loading').addClass('hide');
            });

    });


    $('.documents a').click(function (e) {
        e.preventDefault();
        const url = $(this).attr('href') + '&course=' + $('#list-courses').val();
        window.open(url, '_blank');
    });

})(jQuery);