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
        console.log("Success:", data);
      })
      .catch((error) => {
        alert("An error occurred.");
        console.error("Error:", error);
      });
  });

function loadProducts() {
  fetch("/api/products", {
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
        var newRow = tableBody.insertRow();

        var nameCell = newRow.insertCell(0);
        var priceCell = newRow.insertCell(1);
        var descriptionCell = newRow.insertCell(2);
        var quantityCell = newRow.insertCell(3);
        var editCell = newRow.insertCell(4);

        nameCell.textContent = product.name;
        priceCell.textContent = product.price;
        descriptionCell.textContent = product.description;
        quantityCell.textContent = product.quantity;
        editCell.innerHTML =
          "<button onclick='editFunction(" + product.id + ")'>Edit</button>";
      });
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

window.onload = loadProducts;
