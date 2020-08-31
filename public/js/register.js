$(function() {
    $('#registration_name').change(function() {
        var name = $(this).val();
        $.post(webroot + '/ajax/isUsernameUsed', {name: name}, function(data, stat) {
            if (stat === 'success') {
                var errorDom = $('#registration_name').parent().parent().find('td.form_error');
                $(errorDom).text('');
                if (data.stat === 'used') {
                    $(errorDom).text('Tento uživatel již existuje');
                }
            }
        });
    });
});

