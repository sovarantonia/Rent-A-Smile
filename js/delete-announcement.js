// const deleteButtons = document.querySelectorAll(".delete-button");
// deleteButtons.forEach(button => {
//     button.addEventListener("click", (event) => {
//         event.preventDefault();
//         const confirmDelete = confirm("Are you sure you want to delete this announcement?");
//         if (confirmDelete) {
//             const announcementId = button.parentNode.querySelector("input[name='announcement_id']").value;
//             const form = document.createElement("form");
//             form.method = "POST";
//             form.action = "delete_announcement.php";
//             const input = document.createElement("input");
//             input.type = "hidden";
//             input.name = "announcement_id";
//             input.value = announcementId;
//             form.appendChild(input);
//             document.body.appendChild(form);
//             form.submit();
//         }
//     });
// });

const deleteButtons = document.querySelectorAll(".delete-button");
deleteButtons.forEach(button => {
    button.addEventListener("click", (event) => {
        event.preventDefault();
        const confirmDelete = confirm("Are you sure you want to delete this announcement?");
        if (confirmDelete) {
            const announcementId = button.parentNode.querySelector("input[name='announcement_id']").value;
            const userRole = button.parentNode.querySelector("input[name='role']").value;
            const form = document.createElement("form");
            form.method = "POST";
            form.action = "delete_announcement.php";
            const input = document.createElement("input");
            input.type = "hidden";
            input.name = "announcement_id";
            input.value = announcementId;
            form.appendChild(input);
            const roleInput = document.createElement("input");
            roleInput.type = "hidden";
            roleInput.name = "role";
            roleInput.value = userRole;
            form.appendChild(roleInput);
            document.body.appendChild(form);
            form.submit();
        }
    });
});