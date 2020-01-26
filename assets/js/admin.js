jQuery(document).ready(function ($) {

    // Товару можно присвоить только одну категорию
    $('#product_catchecklist input').each(function () {
        $(this).attr('type', 'radio');
    });

    // Расставляет/снимает дочерним checkbox-ам checked
    $('.wrapper-list-categories').on('change', 'input', function () {
        const input = $(this),
            childrenWrap = input.parent().next();

        if (!childrenWrap.length) return;

        let childrenInputs = childrenWrap.find('input');

        if (input.attr('checked') === 'checked') {
            childrenInputs.attr('checked', 'checked');
        } else {
            childrenInputs.removeAttr('checked')
        }
    });

});
