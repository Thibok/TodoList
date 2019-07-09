$(function () {
    function formSubmit() {
        $("#loginForm").submit();
    }

    window.formSubmit = formSubmit;

    $("#loginBtn").click(function (event) {
        event.preventDefault();
        grecaptcha.reset();
        grecaptcha.execute();
    });
});