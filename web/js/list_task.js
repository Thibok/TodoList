$(function() {
    var viewTaskModal = new jBox("Modal");

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

    $(".task-link").click(function (e) {
        e.preventDefault();

        let idSplit = $(this).attr("id").split("-");

        createViewTaskModal(idSplit[3]);
        viewTaskModal.open();
    });

    $(".delete-task-link").click(function (e) {
        e.preventDefault();

        let link = $(this).attr("href");

        createDeleteTaskModal(link);
        deleteTaskModal.open();
    });
});