$(document).ready(function() {
    $('#wishlistModal').on('show.bs.modal', function() {
        $.ajax({
            url: '/wishlist/load',
            method: 'GET',
            success: function(response) {
                var wishlistItems = '';
                $.each(response.wishlist.products, function(key, product) {
                    wishlistItems += '<li>' + product.name + '</li>';
                });
                $('#wishlistItems').html(wishlistItems);
            },
            error: function(xhr, status, error) {
                console.error('Error loading wishlist: ', error);
            }
        });
    });
});