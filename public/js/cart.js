function displayCart() {

    fetch('/api/cart')
        .then(response => response.json())
        .then(data => {

            let totalPrice = 0;

            const productCards = Object.values(data).map(product => {

                totalPrice += parseFloat(product.price) * product.qty;

                return `
            <div class="inner-cart-flex" style="margin:5px;">
                <img src="/img/${product.image}">
                <div class="d-flex flex-column justify-content-between w-100">
                    <div class="inner-cart-flex-row mob-column">
                        <h2 class="h3" style="text-transform: capitalize">${product.product_name}</h2>
                        <p class="h4 mob-d-none">${product.qty}</p>
                        <p class="h4 bleu">${product.price}€</p>
                    </div>
                    <div class="inner-cart-flex-row">
                        <a class="h4 invisible mob-d-none" role="button" style="color:black;">Modifier</a>
                        <label class="h4 pc-d-none"> QTÉ <input type="text" value="${product.qty}" class="qte"></label>
                        <a class="h4" role="button" onclick="deleteItem(${product.product_id})" style="color:black;">Supprimer</a>
                    </div>
                </div>
            </div>
        `;
            }).join('');

            document.getElementById('cartItems').innerHTML = ''


            document.getElementById('cartItems').innerHTML = productCards;


            document.getElementById('sous-total-value').textContent = `${totalPrice.toFixed(2)}€`;
        })
        .catch(error => {
            console.error('Error fetching the products:', error);
        });

}

function deleteItem(id) {
    removeItem2(id)
        .catch(error => {
            console.error("Error deleting the product:", error);
        });
}

function removeItem2(id) {
    return fetch(`/api/cart/delete/${id}`, {
        method: "POST",
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
        })
        .then(() => {
            location.reload();
        })
        .catch((error) => {
            console.error("There was an error:", error);
            throw error;
        });
}

function placeOrder() {
    event.preventDefault();


    fetch("/api/order", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
    })
        .then(response => {
            if (!response.ok) {
                throw response;
            }
            return response.json();
        })
        .then(data => {
            if (data.message) {
                alert(data.message);
                window.location.href = '/';
            } else if (data.error) {
                alert(data.error);
            }
        })
        .catch(error => {
            console.error("Raw error object:", error);

            if (error && typeof error.json === 'function') {
                error.json().then(errData => {
                    alert(errData.error);
                }).catch(() => {
                    alert("An error occurred while parsing the response.");
                });
            } else if (error && error.status) {
                alert("HTTP Error: " + error.status + " " + error.statusText);
            } else {
                alert("Please Login to pass your order");
            }
        });

}

window.onload = displayCart;

