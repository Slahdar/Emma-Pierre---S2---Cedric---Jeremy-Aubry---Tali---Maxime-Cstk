
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById('new-product-form').addEventListener('submit', function (e) {
        e.preventDefault();  // Prevent the form from submitting normally

        var name = document.getElementById('name').value;
        var price = document.getElementById('price').value;
        var description = document.getElementById('description').value;

        var data = {
            name: name,
            price: price,
            description: description
        };

        fetch('/api/products', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        })
            .then(response => response.json())
            .then(data => {
                alert('Product created successfully!');
                console.log('Success:', data);
            })
            .catch((error) => {
                console.log('error')
            });
    });
});

function loadProducts() {
    fetch('/api/products', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
        }
    })
        .then(response => response.json())
        .then(data => {
            var tableBody = document.getElementById('products-table').getElementsByTagName('tbody')[0];

            data.forEach(product => {
                var newRow = tableBody.insertRow();

                var nameCell = newRow.insertCell(0);
                var priceCell = newRow.insertCell(1);
                var descriptionCell = newRow.insertCell(2);

                nameCell.textContent = product.name;
                priceCell.textContent = product.price;
                descriptionCell.textContent = product.description;
            });
        })
        .catch((error) => {
            console.error('Error:', error);
        });
}

window.onload = loadProducts;
