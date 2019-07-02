$(function () {
    const ajaxLoaderImgPath = "/img/ajax-loader.gif";
    const userPerPage = 10;
    const apiUserUrlProdRegex = new RegExp("^\/app.php\/api\/users\/[0-9]+$");
    const userUrlProdRegex = new RegExp("^\/app.php\/users\/[0-9]+\/edit$");

    var usersLength = $(".user-row").length;
    var userUrl = $(".edit-user-link").eq(0).attr("href");
    var apiUserUrl = $("#loadMoreUsers").attr("data-path");


    if (apiUserUrl !== undefined) {
        if (apiUserUrl.match(apiUserUrlProdRegex)) {
            apiUserUrl = "/app.php/api/users/";
        } else {
            apiUserUrl = "/api/users/";
        }
    }

    if (userUrl !== undefined) {
        if (userUrl.match(userUrlProdRegex)) {
            userUrl = "/app.php/users/";
        } else {
            userUrl = "/users/";
        }
    }

    function createAjaxLoader () {
        let loadImg = $("<div id='ajaxLoader' class='w-100 text-center'><img class='mb-2 mt-2' src='" + ajaxLoaderImgPath + "' alt='loader'/></div>");
        loadImg.css("width", "48px").css("height", "48px");

        return loadImg;
    }

    function createLoadMoreButton () {
        let loadMore = $("<button id='loadMoreUsers' class='btn btn-primary mb-4 mt-2'>Voir plus</button>");

        return loadMore;
    }

    function createUserElement(id, username, email, role) {
        let trElement = $("<tr></tr>");

        let thElement = $("<th class='user-row' scope='row'></th>");
        thElement.text(usersLength);

        let tdUsername = $("<td class='td-user-username'></td>");
        tdUsername.text(username);

        let tdEmail = $("<td class='td-user-email'></td>");
        tdEmail.text(email);

        if (role === "ROLE_USER") {
            role = 'Utilisateur';
        } else if(role === "ROLE_ADMIN") {
            role = 'Administrateur';
        }

        let tdRole = $("<td class='td-user-role'></td>");
        tdRole.text(role);

        let tdEdit = $("<td></td>");
        let editUserBtn = $("<a class='btn btn-success btn-sm edit-user-link'>Edit</a>");
        editUserBtn.attr("href", userUrl + id + "/edit");

        tdEdit.append(editUserBtn);

        trElement.append(thElement);
        trElement.append(tdUsername);
        trElement.append(tdEmail);
        trElement.append(tdRole);
        trElement.append(tdEdit);

        return trElement;
    }

    function loadMoreUsers (button, e) {
        e.preventDefault();

        let page = Math.ceil(usersLength / userPerPage) + 1;
        let url = apiUserUrl + page;
    
        button.replaceWith(createAjaxLoader());
    
        $.get(url, function (datas) {
            if (datas.length === 0) {
                $("#ajaxLoader").remove();
                return;
            }

            $(datas).each(function () {
                usersLength++;
                let user = createUserElement(this["id"], this["username"], this["email"], this["role"]);
                $("tbody").append(user);
            });

            if (datas.length < userPerPage) {
                $("#ajaxLoader").remove();
                return;
            }

            let loadMoreButton = createLoadMoreButton();
            loadMoreButton.click(function (e) {
                loadMoreUsers($(this), e);
            });
    
            $("#ajaxLoader").replaceWith(loadMoreButton);
        }).fail(function () {
            $("#ajaxLoader").remove();
            console.log("Une erreur est survenue");
        });
    }

    $("#loadMoreUsers").click(function (event) {
        loadMoreUsers($(this), event);
    });

    if ($(".user-row").length === 0) {
        $("#loadMoreUsers").remove();
    }
});