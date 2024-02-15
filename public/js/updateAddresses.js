//petición ajax pararellenar el modal de editar dirección de envio
function loadAddressData(addressId) {
    fetch("/addresses/" + addressId)
        .then((response) => response.json())
        .then((data) => {
            document.getElementById("editAddress").value = data.address;
            document.getElementById("editSecondaryAddress").value =
                data.secondary_address;
            document.getElementById("editTelephoneNumber").value =
                data.telephone_number;
            document.getElementById("editCountry").value = data.country;
            document.getElementById("editZip").value = data.zip;
            document.getElementById("editAddressForm").action =
                "/addresses/update/" + data.id;
        })
        .catch((error) => {
            console.error("Error de recogida de datos:", error);
        });
}
