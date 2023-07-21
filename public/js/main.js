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
        loadProducts();
      })
      .catch((error) => {
        alert("An error occurred.");
        console.error("Error:", error);
      });
  });

function loadProducts() {
  console.log("load products executed");

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

      // Clear the table body
      tableBody.innerHTML = "";

      data.forEach((product) => {
        console.log(product);
        var newRow = tableBody.insertRow();

        var nameCell = newRow.insertCell(0);
        var priceCell = newRow.insertCell(1);
        var descriptionCell = newRow.insertCell(2);
        var categorieCell = newRow.insertCell(3);
        var gemTypeCell = newRow.insertCell(4);
        var collectionCell = newRow.insertCell(5);
        var deleteCell = newRow.insertCell(6);

        nameCell.textContent = product.product_name;
        priceCell.textContent = product.price;
        descriptionCell.textContent = product.description;
        categorieCell.textContent = product.category_name;
        gemTypeCell.textContent = product.gem_name;
        collectionCell.textContent = product.collection_name;
        deleteCell.innerHTML =
          "<button onclick='deleteProduct(" +
          product.product_id +
          ")'>Delete</button>";
      });
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

function deleteProduct(id) {
  fetch(`/api/product/delete/${id}`, {
    method: "POST",
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
    })
    .then(() => {
      alert("Product deleted successfully!");
    })
    .catch((error) => {
      console.error("There was an error:", error);
    });

  loadProducts();
}

document.addEventListener('DOMContentLoaded', function() {
  fetch('/api/orders') // Replace with your API endpoint URL
  .then(response => response.json())
  .then(data => {
      let orders = groupByOrderId(data);
      createOrderCards(orders);
  });
});

function groupByOrderId(data) {
  let grouped = {};

  data.forEach(item => {
      if (!grouped[item.order_id]) {
          grouped[item.order_id] = {
              username: item.username,
              order_total: item.order_total,
              nom_prenom: item.nom_prenom,
              numero_rue: item.numero_rue,
              nom_rue: item.nom_rue,
              ville: item.ville,
              code_postal: item.code_postal,



              products: []
          };
      }
      grouped[item.order_id].products.push({
          product_name: item.product_name,
          unit_price: item.unit_price
      });
  });

  return grouped;
}

function createOrderCards(orders) {
  let container = document.getElementById('orders_container');

  for (let orderId in orders) {
      let order = orders[orderId];
    console.log(order);
      let card = document.createElement('div');
      card.className = 'orderCard';

      let usernameEl = document.createElement('p');
      usernameEl.innerText = 'Username : ' + order.username;
      card.appendChild(usernameEl);

      let nomPrenom = document.createElement('p');
      nomPrenom.innerText = 'Name : ' + order.nom_prenom;
      card.appendChild(nomPrenom);

      let adresse = document.createElement('p');
      adresse.innerText = 'Adresse : ' + order.numero_rue + ' ' + order.nom_rue + ' ' + order.code_postal + ' ' + order.ville;
      card.appendChild(adresse);

      let totalEl = document.createElement('p');
      totalEl.innerText = 'Order Total: ' + order.order_total;
      card.appendChild(totalEl);

      let productList = document.createElement('ul');
      order.products.forEach(product => {
          let productEl = document.createElement('li');
          productEl.innerText = product.product_name + ' - ' + product.unit_price;
          productList.appendChild(productEl);
      });
      card.appendChild(productList);

      container.appendChild(card);
  }
}


window.onload = loadProducts;
