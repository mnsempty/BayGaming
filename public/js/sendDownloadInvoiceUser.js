function sendMail(orderId) {
    let csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    let url = `/send-invoice/${orderId}`;
    let enlace = document.querySelector(`a[data-id-order="${orderId}"]`);

    fetch(url, {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
        },
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            enlace.classList.remove(
                "btn-primary",
                "bi-envelope-arrow-down-fill"
            );
            enlace.classList.add("btn-success", "bi-envelope-check-fill");
        })
        .catch((error) => {
            console.error("Error al enviar la factura:", error);
        });
}
//modificamos el botón al hacer click en descargar
function downloadPDF(orderId) {
    let enlace = document.querySelector(`a[data-id-order-pdf="${orderId}"]`);
    // Actualiza el estado del botón
    enlace.classList.remove("btn-primary", "bi-file-earmark-arrow-down-fill");
    enlace.classList.add("btn-success", "bi-file-earmark-check-fill");
}
