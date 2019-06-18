$(function () {
    const titleMinLength = 2;
    const titleMaxLength = 50;
    const titleRegex = new RegExp("^([a-zA-Z0-9]+ ?[a-zA-Z0-9]+)+$");
    const contentMaxLength = 500;
    const contentRegex = new RegExp("[<>]");

    var title = $("#appbundle_task_title");
    var content = $("#appbundle_task_content");

    function formSubmit() {
        $("#taskForm").submit();
    }

    function validateTitle(title) {
        if (title.length < titleMinLength) {
            $("#titleError").text("Le titre doit etre de " + titleMinLength + " caractères minimum.");
            return false;
        }

        if (title.length > titleMaxLength) {
            $("#titleError").text("Le titre doit etre de " + titleMaxLength + " caractères maximum.");
            return false;
        }

        if (!titleRegex.test(title)) {
            $("#titleError").text("Le titre ne peut contenir ques des lettres, des chiffres et des espaces.");
            return false;
        }

        $("#titleError").text("");
        return true;
    }

    function validateContent(content) {
        if (content.length === 0) {
            $("#contentError").text("Vous devez saisir du contenu.");
            return false;
        }

        if (content.length > contentMaxLength) {
            $("#contentError").text("Le contenu doit etre de " + contentMaxLength + " caractères maximum.");
            return false;
        }

        if (contentRegex.test(content)) {
            $("#contentError").text("Le contenu ne doit pas contenir de < ou >");
            return false;
        }

        $("#contentError").text("");
        return true;
    }

    function validateForm() {
        let validTitle = validateTitle(title.val());
        let validContent = validateContent(content.val());

        let results = [validTitle, validContent];

        if ($.inArray(false, results) !== -1) {
            return false;
        }

        return true;
    }

    window.formSubmit = formSubmit;

    $("#createTaskBtn").click(function (event) {
        event.preventDefault();
        if (validateForm()) {
            console.log(validateForm());
            grecaptcha.reset();
            grecaptcha.execute();
        }
    });

    title.on("keyup blur", function () {
        validateTitle($(this).val());
    });

    content.on("keyup blur", function () {
        validateContent($(this).val());
    });
});