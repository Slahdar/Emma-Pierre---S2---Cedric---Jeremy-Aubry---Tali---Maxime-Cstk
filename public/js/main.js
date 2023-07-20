document
    .getElementById("new-product-form")
    .addEventListener("submit", function (e) {
        e.preventDefault(); // Prevent the form from submitting normally

        var formData = new FormData(this);

        fetch("/api/products", {
            method: "POST",
            body: formData,
        })
            .then((response) => response.json())
            .then((data) => {
                alert("Product created successfully!");
                console.log(formData);

            })
            .catch((error) => {
                alert("An error occurred.");
                console.error("Error:", error);
            });
    });

function loadProducts() {
    fetch("/api/productsbis", {
        method: "GET",
        headers: {
            "Content-Type": "application/json",
        },
    })
        .then((response) => response.json())
        .then((data) => {
            var tableBody = document
                .getElementById("products-table")
                .getElementsByTagName("tbody")[0];

            data.forEach((product) => {
                console.log(product);
                var newRow = tableBody.insertRow();

                var nameCell = newRow.insertCell(0);
                var priceCell = newRow.insertCell(1);
                var descriptionCell = newRow.insertCell(2);
                var categorieCell = newRow.insertCell(3);
                var gemTypeCell = newRow.insertCell(4);
                var collectionCell = newRow.insertCell(5);
                var editCell = newRow.insertCell(6);

                nameCell.textContent = product.product_name;
                priceCell.textContent = product.price;
                descriptionCell.textContent = product.description;
                categorieCell.textContent = product.category_name;
                gemTypeCell.textContent = product.gem_name;
                collectionCell.textContent = product.collection_name;
                editCell.innerHTML =
                    "<button onclick='editFunction(" + product.id + ")'>Edit</button>";
            });
        })
        .catch((error) => {
            console.error("Error:", error);
        });
}

window.onload = loadProducts;
