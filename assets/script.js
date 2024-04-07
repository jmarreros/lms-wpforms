(function ($) {
    'use strict';

    // Get brands or models from API, popup window
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


    $('#search-entries').click(function (e) {
        e.preventDefault();

        $.ajax({
            url: lms_forms.ajaxurl,
            type: 'post',
            dataType: 'json',
            data: {
                action: 'dcms_lms_search_entries',
                nonce: lms_forms.nonce_lms_forms,
            }, beforeSend: function () {
                $('#container-report .button').prop('disabled', true);
                $('#container-report .loading').removeClass('hide');
            }
        })
        .done(function (res) {
            $('#container-report .msg-btn').text(res.message);
        })
        .always(function () {
            $('#container-report .button').prop('disabled', false);
            $('#container-report .loading').addClass('hide');
        });

    });

})(jQuery);