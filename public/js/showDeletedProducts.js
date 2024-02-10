$(document).ready(function() {
    $('#filterToggle').change(function() {
        var showDeleted = $(this).prop('checked');
        var url = showDeleted ? '/products/fetchDeleted' : '/products';

        if (showDeleted) {
            // Busca y enseña los productos eliminados
            $.ajax({
                type: "GET",
                url: url,
                dataType: "json",
                success: function(products) {
                    var html =
                        '<table class="table"><thead><tr><th>Name</th><th>Price</th><th>Developer</th><th>Platform</th></tr></thead><tbody>';
                    $.each(products, function(i, product) {
                        html += '<tr><td>' + product.name + '</td><td>' +
                            product.price + '</td><td>' + product.developer +
                            '</td><td>' + product.platform + '</td></tr>';
                    });
                    html += '</tbody></table>';
                    $('#productTableContainer').html(html).show(); // Muestra la tabla
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.error('Error fetching products: ', errorThrown);
                }
            });
        } else {
            // Cuando el toggle está  desactivado, ocultamos la tabla
            $('#productTableContainer').hide().empty(); // Esconde y vacía la tabla
        }
    });
});