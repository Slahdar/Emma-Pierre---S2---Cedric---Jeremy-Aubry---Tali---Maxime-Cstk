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
  window.location.href = "panier.html";
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
