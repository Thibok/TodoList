$(function () {
    function formSubmit() {
        $("#taskForm").submit();
    }

    window.formSubmit = formSubmit;

    $("#createTaskBtn").click(function (event) {
        grecaptcha.reset();
        grecaptcha.execute();    
    });
});