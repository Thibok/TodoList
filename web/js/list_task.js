$(function() {
    const ajaxLoaderImgPath = "/img/ajax-loader.gif";
    const terminateIconTaskPath = "/img/terminate.png";
    const currentIconTaskPath= "/img/current.png";
    const editIconTaskPath= "/img/edit.png";
    const deleteIconTaskPath= "/img/delete.png";
    const taskPerPage = 10;
    const apiTaskUrl = "/api/tasks/";

    var tasksLength = $(".task-container").length;
    var viewTaskModal = new jBox("Modal");

    function createAjaxLoader (id) {
        let loadImg = $("<div id=" + id + " class='w-100 text-center'><img class='mb-2 mt-2' src='" + ajaxLoaderImgPath + "' alt='loader'/></div>");
        loadImg.css("width", "48px").css("height", "48px");

        return loadImg;
    }

    function createLoadMoreButton (id) {
        let loadMore = $("<button id=" + id +" class='btn btn-primary mb-4 mt-2'>Voir plus</button>");

        return loadMore;
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
        taskCardFooterToggleLink.attr("href", "/tasks/" + id + "/toggle");
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
        taskCardFooterEditLink.attr("href", "/tasks/" + id + "/edit");

        let taskCardFooterEditImg = $("<img class='mr-2' alt='Editer une tache'>");
        taskCardFooterEditImg.attr("src", editIconTaskPath);

        taskCardFooterEditLink.append(taskCardFooterEditImg);

        let taskCardFooterDeleteLink = $("<a class='delete-task-link' title='Supprimer'></a>");
        taskCardFooterDeleteLink.attr("id", "task-delete-link-" + tasksLength);
        taskCardFooterDeleteLink.attr("href", "/tasks/" + id + "/delete");

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

    function createViewTaskModal(id) {
        let taskTitle = $("#task-title-link-" + id).text();
        let taskContent = $("#task-content-" + id).text();

        let modalTitle = $("<h4 class='text-primary text-center'>" + taskTitle + "</h4>");
        let modalContent = $("<p>" + taskContent + "</p>");

        viewTaskModal.setTitle(modalTitle);
        viewTaskModal.setContent(modalContent);
    }

    function goToDeleteTask() {
        let url = $("#taskToRemove").text();
        $(location).attr("href", url);
    }

    var deleteTaskModal = new jBox("Confirm", {
        cancelButton: "Annuler",
        confirmButton: "Supprimer",
        confirm: goToDeleteTask,
    });

    function createDeleteTaskModal(link) {
        let taskToRemoveLink = $("<p id='taskToRemove'>" + link + "</p>").hide();
        let modalContent = $("<p>Etes vous sur de vouloir supprimer cette tâche ?</p>");

        let modalContainer = $("<div></div>");

        modalContainer.append(taskToRemoveLink);
        modalContainer.append(modalContent);

        deleteTaskModal.setContent(modalContainer);
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

    if ($(".task-container").length === 0) {
        $("#loadMoreTasks").remove();
    }
});