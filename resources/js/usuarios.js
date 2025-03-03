document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("buscar"),
          roleSelect = document.getElementById("rol"),
          tableContainer = document.getElementById("tabla-usuarios"),
          editForm = document.getElementById("edit-user-form");

    // Obtener valores desde las etiquetas <meta>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
    const usuariosRoute = document.querySelector('meta[name="ruta-usuarios"]').getAttribute("content");
    const historialRoute = document.querySelector('meta[name="ruta-historial"]').getAttribute("content");

    function fetchUsers() {
        let query = new URLSearchParams({
            buscar: searchInput.value,
            rol: roleSelect.value
        }).toString();

        fetch(usuariosRoute + "?" + query, {
            headers: { "X-Requested-With": "XMLHttpRequest" }
        })
        .then(response => response.json())
        .then(data => {
            tableContainer.innerHTML = data.html;
            attachEventListeners(); // Reactivar eventos después de actualizar la tabla
        })
        .catch(error => console.error("Error:", error));
    }

    function attachEventListeners() {
        document.querySelectorAll(".fila-usuario").forEach(row => {
            row.addEventListener("click", function (event) {
                if (!event.target.closest("button, input[type='checkbox']")) {
                    let userId = this.getAttribute("data-user-id");
                    let url = historialRoute + "/" + userId;
                    console.log("Redirigiendo a:", url);
                    window.location.href = url;
                }
            });
        });

        document.querySelectorAll(".eliminar-btn").forEach(button => {
            button.addEventListener("click", function (event) {
                event.stopPropagation();
                let userId = this.getAttribute("data-user-id");

                Swal.fire({
                    title: "¿Estás seguro?",
                    text: "Esta acción no se puede deshacer",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Sí, eliminar",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(usuariosRoute + "/" + userId, {
                            method: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": csrfToken,
                                "Content-Type": "application/json"
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            Swal.fire({
                                title: data.success ? "Eliminado" : "Error",
                                text: data.message || "No se pudo eliminar el usuario.",
                                icon: data.success ? "success" : "error",
                                timer: 2000,
                                showConfirmButton: false
                            });
                            if (data.success) setTimeout(fetchUsers, 1500);
                        })
                        .catch(error => Swal.fire("Error", "Hubo un problema al eliminar el usuario.", "error"));
                    }
                });
            });
        });

        let selectAll = document.getElementById("select-all");
        if (selectAll) {
            selectAll.addEventListener("click", function () {
                document.querySelectorAll('input[name="usuarios[]"]').forEach(checkbox => checkbox.checked = this.checked);
            });
        }
    }

    function actualizarUsuariosSeleccionados() {
        let selectedUsers = [];
        document.querySelectorAll('input[name="usuarios[]"]:checked').forEach((checkbox) => {
            selectedUsers.push(checkbox.value);
        });
        document.getElementById('selected-users').value = selectedUsers.join(",");
    }

    function handleEditUserForm() {
        if (!editForm) return;

        editForm.addEventListener("submit", function (event) {
            event.preventDefault();
            let formData = new FormData(this),
                actionUrl = this.getAttribute("action");

            fetch(actionUrl, {
                method: "POST",
                headers: { "X-Requested-With": "XMLHttpRequest" },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                Swal.fire({
                    title: data.success ? "Usuario actualizado" : "Error",
                    text: data.message || "No se pudo actualizar el usuario.",
                    icon: data.success ? "success" : "error",
                    timer: 2000,
                    showConfirmButton: false
                });

                if (data.success) setTimeout(() => window.location.href = usuariosRoute, 1500);
            })
            .catch(error => Swal.fire("Error", "Hubo un problema al actualizar el usuario.", "error"));
        });
    }

    searchInput.addEventListener("input", fetchUsers);
    roleSelect.addEventListener("change", fetchUsers);
    attachEventListeners();
    handleEditUserForm();
    
    // Asegurar que los usuarios seleccionados se envían al formulario
    document.querySelector("form[action*='pdf-masivo']").addEventListener("submit", actualizarUsuariosSeleccionados);
});
