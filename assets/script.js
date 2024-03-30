(function ($) {
    'use strict';

    // Get brands or models from API, popup window
    $('#btn-save-fields').click(function (e) {
        e.preventDefault();

        $.ajax({
            url: lms_forms.ajaxurl,
            type: 'post',
            dataType: 'json',
            data: {
                action: 'dcms_lms_forms_save_fields',
                nonce: lms_forms.nonce_lms_forms,
            },
            beforeSend: function () {

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