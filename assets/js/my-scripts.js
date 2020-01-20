jQuery(document).ready(function($) {
    const ajax_url = woocommerce_params.ajax_url || {};

    function send_forms() {
        const formData = $(this).serializeArray(),
            data = {};

        formData.forEach(function (item) {
            data[item.name] = item.value;
        });

        $.ajax({
            url: ajax_url,
            type: 'post',
            dataType: 'json',
            data: {
                action: 'lt_ajax_send_forms',
                form_data: data,
            },
            success: function(result) {
                if (result.errors) {
                    console.log(result.errors);
                } else {
                    console.log('Показать спасибо');
                }
            }
        });

        return false;
    }

    $('.form-box').submit(send_forms);
    $('.quiz-form').submit(send_forms);

});
