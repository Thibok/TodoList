$(function () {
    const usernameMinLength = 4;
    const usernameMaxLength = 30;
    const usernameRegex = new RegExp("^[a-zA-Z0-9_-]{4,}$");
    const passwordMinLength = 8;
    const passwordMaxLength = 48;
    const passwordRegex = new RegExp("^(?=.*[0-9])(?=.*[a-zA-Z]).{8,}$");
    const emailMinLength = 7;
    const emailMaxLength = 60;
    const emailRegex = new RegExp("^[a-z0-9._-]+@[a-z0-9._-]{2,}\\.[a-z]{2,4}$");

    var username = $("#appbundle_user_username");
    var passwordFirst = $("#appbundle_user_password_first");
    var passwordSecond = $("#appbundle_user_password_second");
    var email = $("#appbundle_user_email");
    
    function validateUsername(username) {
        if (username.length < usernameMinLength) {
            $("#usernameError").text("Le nom d'utilisateur doit etre de " + usernameMinLength + " caractères minimum.");
            return false;
        }

        if (username.length > usernameMaxLength) {
            $("#usernameError").text("Le nom d'utilisateur doit etre de " + usernameMaxLength + " caractères maximum.");
            return false;
        }

        if (!usernameRegex.test(username)) {
            $("#usernameError").text("Le nom d'utilisateur peut contenir lettres, chiffres et tirets.");
            return false;
        }

        $("#usernameError").text("");
        return true;
    }

    function validatePassword(password) {
        if (password.length < passwordMinLength) {
            $("#firstPassError").text("Le mot de passe doit etre de " + passwordMinLength + " caractères minimum.");
            return false;
        }

        if (password.length > passwordMaxLength) {
            $("#firstPassError").text("Le mot de passe doit etre de " + passwordMaxLength + " caractères maximum.");
            return false;
        }

        if (!passwordRegex.test(password)) {
            $("#firstPassError").text("Le mot de passe doit contenir au moins une lettre et un chiffre.");
            return false;
        }

        $("#firstPassError").text("");
        return true;
    }

    function validateSamePassword(firstPass, secondPass) {
        if (!validatePassword(firstPass)) {
            return false;
        }

        if (firstPass !== secondPass) {
            $("#firstPassError").text("Les deux mots de passe doivent correspondre.");
            return false;
        }

        $("#firstPassError").text("");
        return true;
    }

    function validateEmail(email) {
        if (email.length < emailMinLength) {
            $("#emailError").text("L'adresse email doit être de 7 caractères minimum.");
            return false;
        }

        if (email.length > emailMaxLength) {
            $("#emailError").text("L'adresse email doit être de 60 caractères maximum.");
            return false;
        }

        if (!emailRegex.test(email)) {
            $("#emailError").text("Merci d'entrer une adresse email valide.");
            return false;
        }

        $("#emailError").text("");
        return true;
    }

    function validateForm() {
        let validUsername = validateUsername(username.val());
        let validPassword = validatePassword(passwordFirst.val());
        let validSamePass = validateSamePassword(passwordFirst.val(), passwordSecond.val());
        let validEmail = validateEmail(email.val());

        let results = [validUsername, validPassword, validSamePass, validEmail];

        if ($.inArray(false, results) !== -1) {
            return false;
        }

        return true;
    }

    function formSubmit() {
        $("#userForm").submit();
    }

    window.formSubmit = formSubmit;

    username.on("keyup blur", function () {
        validateUsername($(this).val());
    });

    passwordFirst.on("keyup blur", function () {
        validatePassword($(this).val());
    });

    passwordSecond.on("keyup blur", function () {
        validateSamePassword(passwordFirst.val(), $(this).val());
    });

    email.on("keyup blur", function () {
        validateEmail($(this).val());
    });

    $("#createUserBtn").click(function (event) {
        event.preventDefault();
        if (validateForm()) {
            grecaptcha.reset();
            grecaptcha.execute();
        }
    });

    $("#editUserBtn").click(function (event) {
        event.preventDefault();
        if (validateForm()) {
            grecaptcha.reset();
            grecaptcha.execute();
        }
    });
});