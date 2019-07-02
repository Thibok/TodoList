require('../css/app.css');

$(function () {
    $(".alert").hide();
    
    $(".alert").each(function (index) {
        var duration = 3000 * (index + 1);
        $(this).show();

        $(this).fadeOut(duration, function() {
            $(this).remove();
        });
    });
});