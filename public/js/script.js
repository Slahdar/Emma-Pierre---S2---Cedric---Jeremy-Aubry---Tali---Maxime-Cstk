const firstDiv = document.getElementById("first-div");
const secondDiv = document.getElementById("block-3");

// Hide the second div initially
secondDiv.style.display = "none";

// Add a mouseenter event listener to the first div
firstDiv.addEventListener("mouseenter", function () {
  // Show the second div
  secondDiv.style.display = "flex";
});

// Add a mouseleave event listener to the first div
firstDiv.addEventListener("mouseleave", function () {
  // Check if the mouse is hovering over the second div
  const isHovering = isMouseHovering(secondDiv);

  // If the mouse is not hovering over the second div, hide it
  if (!isHovering) {
    secondDiv.style.display = "none";
  }
});

// Add a mouseenter event listener to the second div
secondDiv.addEventListener("mouseenter", function () {
  // Show the second div
  secondDiv.style.display = "flex";
});

// Add a mouseleave event listener to the second div
secondDiv.addEventListener("mouseleave", function () {
  // Hide the second div
  secondDiv.style.display = "none";
});

// Helper function to check if the mouse is hovering over an element
function isMouseHovering(element) {
  const { top, left, bottom, right } = element.getBoundingClientRect();
  const { clientX, clientY } = event;

  return (
    clientX >= left && clientX <= right && clientY >= top && clientY <= bottom
  );
}

const toggleDiv = document.getElementById("cart-btn");
const otherDiv = document.getElementById("cart");

// Hide the other div initially
otherDiv.style.display = "none";

// Add a click event listener to the toggle div
toggleDiv.addEventListener("click", function () {
  // Toggle the display of the other div
  if (otherDiv.style.display === "none") {
    otherDiv.style.display = "block";
  } else {
    otherDiv.style.display = "none";
  }
});

const burger = document.getElementById("burger");
const burgerMenu = document.getElementById("block-2");

// Add a click event listener to the toggle div
burger.addEventListener("click", function () {
  // Toggle the display of the other div
  if (burgerMenu.style.display === "none") {
    burgerMenu.style.display = "flex";
  } else {
    burgerMenu.style.display = "none";
  }
});

window.addEventListener("scroll", function () {
  var navbar = document.getElementById("header-container");
  if (window.pageYOffset > 20) {
    navbar.style.backgroundColor = "white";
  }
  if (window.pageYOffset === 0) {
    navbar.style.backgroundColor = "#ffffff87";
  }
});
// });

function panier() {
  window.location.href = "/cart";
}

function product_list() {
  window.location.href = "product_list.html";
}
function product_page(id) {
  window.location.href = `/product/${id}`;
}

function precieuse() {
  window.location.href = "collection-precieuse.html";
}

function impertinente() {
  window.location.href = "collection-impertinente.html";
}

function unique() {
  window.location.href = "collection-unique.html";
}

window.onload = refreshCart();

function refreshCart() {
  console.log('executing refresh cart');
  
  fetch("/api/cart", {
    method: "GET",
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((response) => response.json())
    .then((data) => {
      const cartItems = document.getElementById("cart-items");
      const dataArray = Object.values(data);
      
      let totalSum = 0; // Initialize total sum

      const fragment = document.createDocumentFragment();

      dataArray.forEach((element) => {
        const productCard = document.createElement("div");
        productCard.classList.add("cart-item");

        productCard.innerHTML = `
        <div class="item-image-container">
            <img src="/img/${element.image}" alt="${element.product_name}">
        </div>
        <div class="cart-item-info">
            <p>${element.product_name}</p>
            <p>${element.price}€</p>
            <div class="cart-item-btns">
                <p>Quantité : ${element.qty}</p>
                <p style="cursor:pointer;" onclick="removeItem(${element.product_id})">Supprimer</p>
            </div>
        </div>`;
        
        fragment.appendChild(productCard);
        
        // Calculate total sum for each item in the cart
        totalSum += parseFloat(element.price) * element.qty;
      });

      cartItems.innerHTML = "";
      cartItems.appendChild(fragment);

      // Update the total displayed on the page
      const totalElement = document.querySelector(".cart-total>p");
      totalElement.innerHTML = totalSum.toFixed(2) + "€";  // toFixed(2) ensures 2 decimal places

    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

function removeItem(id) {
  const cartItems = document.getElementById("cart-items");
  cartItems.innerHTML = "";
  fetch(`/api/cart/delete/${id}`, {
    method: "POST",
  })
    .then((response) => {
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
    })
    .then(() => {
      refreshCart();
      //alert("Product deleted successfully!");
    })
    .catch((error) => {
      console.error("There was an error:", error);
    });
}

function emptyCart() {
  fetch(`/api/cart/deleteall`, {
    method: "GET",
  })
    .then((response) => {
      console.log(response);
      if (!response.ok) {
        throw new Error(`HTTP error! Status: ${response.status}`);
      }
    })
    .then(() => {
      const cartItems = document.getElementById("cart-items");
      cartItems.innerHTML = "";
      const total = document.querySelector(".cart-total>p");

      total.innerHTML = "0€";
      //alert("Product deleted successfully!");
    })
    .catch((error) => {
      console.error("There was an error:", error);
    });
}
