$(function() {
    const ajaxLoaderImgPath = "/img/ajax-loader.gif";
    const terminateIconTaskPath = "/img/terminate.png";
    const currentIconTaskPath= "/img/current.png";
    const editIconTaskPath= "/img/edit.png";
    const deleteIconTaskPath= "/img/delete.png";
    const taskPerPage = 12;
    const apiTaskUrlProdRegex = new RegExp("^\/app\.php\/api\/tasks\/(current|finish|unknow)\/[0-9]+$");
    const taskUrlProdRegex = new RegExp("^\/app.php\/tasks\/[0-9]+\/(toggle|edit)$");

    var tasksLength = $(".task-container").length;
    var unknowTaskLength = $(".unknow-task-container").length;
    var viewTaskModal = new jBox("Modal");

    var apiTaskUrl = $("#loadMoreTasks").attr("data-path");
    var taskUrl = $(".edit-task-link").eq(0).attr("href");

    if (apiTaskUrl !== undefined) {
        if (apiTaskUrl.match(apiTaskUrlProdRegex)) {
            apiTaskUrl = "/app.php/api/tasks/";
        } else {
            apiTaskUrl = "/api/tasks/";
        }
    }

    if (taskUrl !== undefined) {

        if (taskUrl.match(taskUrlProdRegex)) {
            taskUrl = "/app.php/tasks/";
        } else {
            taskUrl = "/tasks/";
        }
    }

    function createAjaxLoader (id) {
        let loadImg = $("<img id=" + id +" class='mb-2 mt-3' src='" + ajaxLoaderImgPath + "' alt='loader'/>");
        loadImg.css("width", "48px").css("height", "48px");

        return loadImg;
    }

    function createLoadMoreButton (id) {
        let loadMore = $("<button id=" + id +" class='btn btn-primary mb-4 mt-3'>Voir plus</button>");

        return loadMore;
    }

    function confirmDelete (message) {
        let flashContainer = $("<div class='alert alert-success' role='alert'></div>");
        let flashStrongMsg = $("<strong>Superbe ! </strong>");
        let flashMsg = $("<span></span>");
        flashMsg.text(message)
        
        flashContainer.append(flashStrongMsg);
        flashContainer.append(flashMsg);

        flashContainer.hide();

        $("#homepageHeaderContainer").prepend(flashContainer);
    
        $(".alert").each(function (index) {
            var duration = 3000 * (index + 1);
            $(this).show();

            $(this).fadeOut(duration, function() {
                $(this).remove();
            });
        });
    }

    function createTaskElement(id, title, content) {
        let status;

        if ($("#taskTitleStatus").text() === "Tâches en cours") {
            status = "current";
        } else if ($("#taskTitleStatus").text() === "Tâches terminées") {
            status = "finish";
        }

        let taskContainer = $("<div class='col-md-3 mt-2 mb-1 task-container'></div>");

        let taskCard = $("<div class='card h-100'></div>");

        let taskCardBody = $("<div class='card-body'></div>");  

        let taskCardTitle = $("<h4 class='card-title task-title text-truncate'></h4>");

        let taskCardTitleLink = $("<a class='text-decoration-none task-link' href='#'></a>");
        taskCardTitleLink.attr("id", "task-title-link-" + tasksLength);
        taskCardTitleLink.text(title);

        taskCardTitleLink.click(function (event) {
            event.preventDefault();

            let idSplit = $(this).attr("id").split("-");

            createViewTaskModal(idSplit[3]);
            viewTaskModal.open();
        });

        taskCardTitle.append(taskCardTitleLink);

        let taskCardContent = $("<p class='text-truncate card-text task-content'></p>")
        taskCardContent.attr("id", "task-content-" + tasksLength);
        taskCardContent.text(content);

        taskCardBody.append(taskCardTitle);
        taskCardBody.append(taskCardContent);

        let taskCardFooter = $("<div class='card-footer'></div>");
        let taskCardFooterToggleLink = $("<a class='toggle-task-link'></a>");
        taskCardFooterToggleLink.attr("href", taskUrl + id + "/toggle");
        let taskCardFooterToggleImg = $("<img class='mr-2'/>");

        if (status === "current") {
            taskCardFooterToggleLink.attr("title", "Terminer");
            taskCardFooterToggleImg.attr("src", terminateIconTaskPath);
            taskCardFooterToggleImg.attr("alt", "Marquer comme terminée");

        } else if (status === "finish") {
            taskCardFooterToggleLink.attr("title", "Non terminer");
            taskCardFooterToggleImg.attr('src', currentIconTaskPath);
            taskCardFooterToggleImg.attr("alt", "Marquer comme non terminée");
        }

        taskCardFooterToggleLink.append(taskCardFooterToggleImg);

        let taskCardFooterEditLink = $("<a class='edit-task-link' title='Editer'></a>");
        taskCardFooterEditLink.attr("href", taskUrl + id + "/edit");

        let taskCardFooterEditImg = $("<img class='mr-2' alt='Editer une tache'>");
        taskCardFooterEditImg.attr("src", editIconTaskPath);

        taskCardFooterEditLink.append(taskCardFooterEditImg);

        let taskCardFooterDeleteLink = $("<a class='delete-task-link' title='Supprimer'></a>");
        taskCardFooterDeleteLink.attr("id", "task-delete-link-" + tasksLength);
        taskCardFooterDeleteLink.attr("href", apiTaskUrl + id);

        taskCardFooterDeleteLink.click(function (event) {
            event.preventDefault();

            let link = $(this).attr("href");

            createDeleteTaskModal(link);
            deleteTaskModal.open();
        });

        let taskCardFooterDeleteImg = $("<img alt='Supprimer une tache'/>");
        taskCardFooterDeleteImg.attr("src", deleteIconTaskPath);

        taskCardFooterDeleteLink.append(taskCardFooterDeleteImg);

        taskCardFooter.append(taskCardFooterToggleLink);
        taskCardFooter.append(taskCardFooterEditLink);
        taskCardFooter.append(taskCardFooterDeleteLink);

        taskCardBody.append(taskCardTitle);
        taskCardBody.append(taskCardContent);

        taskCard.append(taskCardBody);
        taskCard.append(taskCardFooter);

        taskContainer.append(taskCard);

        return taskContainer;
    }

    function createUnknowTaskElement(id, title) {
        let taskContainer = $("<div class='d-flex justify-content-around px-5 mb-1 unknow-task-container'>");

        let taskLi = $("<li class='text-truncate w-100'></li>");
        taskLi.text(title);  

        let taskLiDeleteLink = $("<a class='delete-unknow-task-link' title='Supprimer'></a>");
        taskLiDeleteLink.attr("href", apiTaskUrl + id);

        taskLiDeleteLink.click(function (event) {
            event.preventDefault();

            let link = $(this).attr("href");

            createDeleteUnknowTaskModal(link);
            unknowTaskModal.open();
        });

        let taskLiDeleteImg = $("<img alt='Supprimer une tache'/>");
        taskLiDeleteImg.attr("src", deleteIconTaskPath);

        taskLiDeleteLink.append(taskLiDeleteImg);

        taskContainer.append(taskLi);
        taskContainer.append(taskLiDeleteLink);

        return taskContainer;
    }

    function createViewTaskModal(id) {
        let taskTitle = $("#task-title-link-" + id).text();
        let taskContent = $("#task-content-" + id).text();

        let modalTitle = $("<h4 class='text-primary text-center'>" + taskTitle + "</h4>");
        let modalContent = $("<p>" + taskContent + "</p>");

        viewTaskModal.setTitle(modalTitle);
        viewTaskModal.setContent(modalContent);
    }

    function goToDeleteUnknowTask() {
        let url = $("#unknowTaskToRemove").text();
        $("#unknowTaskToRemove").text('');

        $.ajax({
            url: url,
            type: "DELETE",
            success: function(response) {
                $("a[href$='" + url + "']").parent().remove();
                unknowTaskLength--;

                confirmDelete("La tâche a bien été supprimée.");

                if (unknowTaskLength === 0 && $("#loadMoreUnknowTasks").length === 0) {
                    let noTasks = $("<p class='px-5 mt-2 ml-1' id='noTasks'></p>");
                    noTasks.text("Il n'y a aucune tâches inconnues");
    
                    $("#unknowTaskRow").append(noTasks);
                    $("#unknowTasksContainer").remove();
                }
            },
            error: function () {
                console.log("Une erreur est survenue");
            }
        });
    }

    function goToDeleteTask() {
        let url = $("#taskToRemove").text();
        $("#taskToRemove").text('');

        $.ajax({
            url: url,
            type: "DELETE",
            success: function(response) {
                $("a[href$='" + url + "']").parent().parent().parent().remove();
                tasksLength--;

                confirmDelete("La tâche a bien été supprimée.");

                if (tasksLength === 0 && $("#loadMoreTasks").length === 0) {
                    let noTasks = $("<p class='ml-3 mt-2 w-100' id='noTasks'></p>");
                    noTasks.text("Il n'y a aucune " + $("#taskTitleStatus").text().toLowerCase());
    
                    $("#taskRow").append(noTasks);
                }
            },
            error: function () {
                console.log("Une erreur est survenue");
            }
        });
    }

    var deleteTaskModal = new jBox("Confirm", {
        cancelButton: "Annuler",
        confirmButton: "Supprimer",
        confirm: goToDeleteTask,
    });

    var unknowTaskModal = new jBox("Confirm", {
        cancelButton: "Annuler",
        confirmButton: "Supprimer",
        confirm: goToDeleteUnknowTask,
    });

    function createDeleteTaskModal(link) {
        let taskToRemoveLink = $("<p id='taskToRemove'>" + link + "</p>").hide();
        let modalContent = $("<p>Etes vous sur de vouloir supprimer cette tâche ?</p>");

        let modalContainer = $("<div></div>");

        modalContainer.append(taskToRemoveLink);
        modalContainer.append(modalContent);

        deleteTaskModal.setContent(modalContainer);
    }

    function createDeleteUnknowTaskModal(link) {
        let taskToRemoveLink = $("<p id='unknowTaskToRemove'>" + link + "</p>").hide();
        let modalContent = $("<p>Etes vous sur de vouloir supprimer cette tâche ?</p>");

        let modalContainer = $("<div></div>");

        modalContainer.append(taskToRemoveLink);
        modalContainer.append(modalContent);

        unknowTaskModal.setContent(modalContainer);
    }

    function loadMoreTasks (button, event) {
        event.preventDefault();

        let status;

        if ($("#taskTitleStatus").text() === "Tâches en cours") {
            status = "current";
        } else if ($("#taskTitleStatus").text() === "Tâches terminées") {
            status = "finish";
        }

        let page = Math.ceil(tasksLength / taskPerPage) + 1;
        let url = apiTaskUrl + status + "/" + page;
    
        button.replaceWith(createAjaxLoader("tasksLoader"));
    
        $.get(url, function (datas) {
            if (datas.length === 0 && tasksLength === 0) {
                let noTasks = $("<p class='ml-3 mt-2 w-100' id='noTasks'></p>");
                noTasks.text("Il n'y a aucune " + $("#taskTitleStatus").text().toLowerCase());
    
                $("#taskRow").append(noTasks);
            }

            if (datas.length === 0) {
                $("#tasksLoader").remove();
                return;
            }

            $(datas).each(function () {
                let task = createTaskElement(this["id"], this["title"], this["content"]);
                tasksLength++;
                $("#taskRow").append(task);
            });

            if (datas.length < taskPerPage) {
                $("#tasksLoader").remove();
                return;
            }

            let loadMoreButton = createLoadMoreButton("loadMoreTasks");
            loadMoreButton.click(function (e) {
                loadMoreTasks($(this), e);
            });
    
            $("#tasksLoader").replaceWith(loadMoreButton);
        }).fail(function () {
            $("#tasksLoader").remove();
            console.log("Une erreur est survenue");
        });
    }
    
    function loadMoreUnknowTasks (button, event) {
        event.preventDefault();

        let page = Math.ceil(unknowTaskLength / taskPerPage) + 1;
        let url = apiTaskUrl + "unknow/" + page;
    
        button.replaceWith(createAjaxLoader("unknowTasksLoader"));
    
        $.get(url, function (datas) {
            if (datas.length === 0 && unknowTaskLength === 0) {
                let noTasks = $("<p class='px-5 mt-2 ml-1' id='noTasks'></p>");
                noTasks.text("Il n'y a aucune tâches inconnues");
    
                $("#unknowTaskRow").append(noTasks);
                $("#unknowTasksContainer").remove();
            }

            if (datas.length === 0) {
                $("#unknowTasksLoader").remove();
                return;
            }

            $(datas).each(function () {
                let unknowTask = createUnknowTaskElement(this["id"], this["title"]);
                unknowTaskLength++;
                $("#unknowTasksContainer").append(unknowTask);
            });

            if (datas.length < taskPerPage) {
                $("#unknowTasksLoader").remove();
                return;
            }

            let loadMoreButton = createLoadMoreButton("loadMoreUnknowTasks");
            loadMoreButton.click(function (e) {
                loadMoreUnknowTasks($(this), e);
            });
    
            $("#unknowTasksLoader").replaceWith(loadMoreButton);
        }).fail(function () {
            $("#unknowTasksLoader").remove();
            console.log("Une erreur est survenue");
        });
    }

    $(".task-link").click(function (event) {
        event.preventDefault();

        let idSplit = $(this).attr("id").split("-");

        createViewTaskModal(idSplit[3]);
        viewTaskModal.open();
    });

    $(".delete-task-link").click(function (event) {
        event.preventDefault();

        let link = $(this).attr("href");

        createDeleteTaskModal(link);
        deleteTaskModal.open();
    });

    $("#loadMoreTasks").click(function (event) {
        loadMoreTasks($(this), event);
    });

    $("#loadMoreUnknowTasks").click(function (event) {
        loadMoreUnknowTasks($(this), event);
    });

    if ($(".task-container").length < taskPerPage) {
        $("#loadMoreTasksContainer").remove();
    }
});