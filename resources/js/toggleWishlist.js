document.addEventListener('DOMContentLoaded', function() {
    function toggleWishlistButton(productId) {
        fetch(`/wishlist/toggle/${productId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
        })
            .then(response => response.json())
            .then(data => {
                const button = document.getElementById(`wishlist-button-${productId}`);
                if (data.status === 'added') {
                    button.innerHTML = '<i class="fas fa-star"></i>';
                    button.classList.add('active');
                } else {
                    button.innerHTML = '<i class="far fa-star"></i>';
                    button.classList.remove('active');
                }
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    }

    function loadWishlist() {
        fetch('/wishlist/show')
            .then(response => response.json())
            .then(data => {
                const wishlistItems = document.getElementById('wishlistItems');
                wishlistItems.innerHTML = '';
                data.forEach(product => {
                    const li = document.createElement('li');
                    li.textContent = product.name;
                    const deleteButton = document.createElement('button');
                    deleteButton.textContent = 'Eliminar';
                    deleteButton.onclick = () => removeFromWishlist(product.id);
                    li.appendChild(deleteButton);
                    wishlistItems.appendChild(li);
                });
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    }

    function removeFromWishlist(productId) {
        fetch(`/wishlist/remove/${productId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
        })
            .then(() => {
                loadWishlist(); // Recarga la lista de deseos después de eliminar un producto
            })
            .catch((error) => {
                console.error('Error:', error);
            });
    }

    // Llama a la función loadWishlist cuando se abre el modal
    document.addEventListener('shown.bs.modal', function (event) {
        if (event.target.id === 'wishlistModal') {
            loadWishlist();
        }
    });
});
