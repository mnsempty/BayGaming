// Función para cargar los datos del usuario en el modal
function loadUserData() {
    // Realiza una solicitud AJAX para obtener los datos del usuario
    fetch("/userProfile")
        .then((response) => response.json())
        .then((data) => {
            // Llena los campos del formulario en el modal con los datos del usuario
            document.getElementById("editProfileForm").action = "/editProfile";
            document.getElementById("editName").value = data.name;
            document.getElementById("editReal_name").value = data.real_name;
            document.getElementById("editSurname").value = data.surname;
            document.getElementById("editEmail").value = data.email;
        })
        .catch((error) => {
            console.error("Error al cargar los datos del usuario:", error);
        });
}
