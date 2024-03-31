(function ($) {
    'use strict';

    // Get brands or models from API, popup window
    $('#btn-save-fields').click(function (e) {
        e.preventDefault();

        let fields = [];
        $('#form-fields tbody tr').each(function (index, element) {
            const id = $(element).attr('id');
            const label = $(element).find('.label').text();
            const type = $(element).find('.type').text();
            const options = $(element).find('.options').text();
            const document = $(element).find('.document').val();
            const order = $(element).find('.order').val();

            fields.push({
                id: id, label:label, type:type, options:options, document: document, order: order
            });
        });

        $.ajax({
            url: lms_forms.ajaxurl, type: 'post', dataType: 'json', data: {
                action: 'dcms_lms_forms_save_fields', nonce: lms_forms.nonce_lms_forms, fields: fields
            }, beforeSend: function () {
            }
        })
            .done(function (res) {
                if (res.success) {
                    console.log(res.data);
                } else {
                    console.log(res.data);
                }
            });
    });

})(jQuery);