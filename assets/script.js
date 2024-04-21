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


    // For filtering, reporting screen
    $('#search-entries').click(function (e) {
        e.preventDefault();

        const dateFrom = $('#date-from').val();
        const dateTo = $('#date-to').val();
        const course = $('#list-courses').val();



        $.ajax({
            url: lms_forms.ajaxurl,
            type: 'post',
            dataType: 'json',
            data: {
                action: 'dcms_lms_search_entries',
                dateFrom: dateFrom,
                dateTo: dateTo,
                course: course,
                nonce: lms_forms.nonce_lms_forms,
            }, beforeSend: function () {
                $('#container-report input').prop('disabled', true);
                $('#container-report select').prop('disabled', true);
                $('#container-report .loading').removeClass('hide');
            }
        })
            .done(function (res) {
                if (res.message === 'success') {

                    let r = Array();
                    let j = -1;

                    const documents_url = lms_forms.documents.map((document) => {
                        return lms_forms.admin_url + '&view=detail&document_name=' + document + '&item_id=';
                    });

                    for (let i = 0; i < res.data.length; i++) {

                        const entry_url = lms_forms.entries_url + res.data[i].entry_id_wpforms;
                        r[++j] = "<tr><td>";
                        r[++j] = res.data[i].course_name;
                        r[++j] = "</td><td>";
                        r[++j] = res.data[i].user_name;
                        r[++j] = "</td><td>";
                        r[++j] = res.data[i].author_name;
                        r[++j] = "</td><td>";
                        r[++j] = "<a href='" + documents_url[0] + res.data[i].id + "' target='_blank'>Ver</a>";
                        r[++j] = "</td><td>";
                        r[++j] = "<a href='" + documents_url[1] + res.data[i].id + "' target='_blank'>Ver</a>";
                        r[++j] = "</td><td>";
                        r[++j] = "<a href='" + documents_url[2] + res.data[i].id + "' target='_blank'>Ver</a>";
                        r[++j] = "</td><td>";
                        r[++j] = "<a href='" + entry_url + "' target='_blank'>Ver</a>";
                        r[++j] = "</td></tr>";
                    }

                    $('#table-report tbody').html(r.join(''));
                }
            })
            .always(function () {
                $('#container-report input').prop('disabled', false);
                $('#container-report select').prop('disabled', false);
                $('#container-report .loading').addClass('hide');
            });

    });

})(jQuery);