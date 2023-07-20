let allProducts = [];

// Fetch product data from the API once on page load
fetch("/api/products")
  .then((response) => response.json())
  .then((products) => {
    allProducts = products;
    updateProductContainer(allProducts); // Display all products by default

    // Attach event listeners to checkboxes after the initial load
    document.querySelectorAll('input[type="checkbox"]').forEach((checkbox) => {
      checkbox.addEventListener("change", handleFilterChange);
    });
  })
  .catch((error) => {
    console.error("There was an error fetching the products:", error);
  });

function handleFilterChange() {
  const selectedCollections = Array.from(
    document.querySelectorAll('input[name="collections[]"]:checked')
  ).map((checkbox) => checkbox.value);

  const selectedGemTypes = Array.from(
    document.querySelectorAll('input[name="gemTypes[]"]:checked')
  ).map((checkbox) => checkbox.value);

  const selectedCategories = Array.from(
    document.querySelectorAll('input[name="categories[]"]:checked')
  ).map((checkbox) => checkbox.value);

  const filteredProducts = allProducts.filter((product) => {
    return (
      (!selectedCollections.length ||
        selectedCollections.includes(String(product.collection_id))) &&
      (!selectedGemTypes.length ||
        selectedGemTypes.includes(String(product.gem_id))) &&
      (!selectedCategories.length ||
        selectedCategories.includes(String(product.category_id)))
    );
  });

  updateProductContainer(filteredProducts);
}

function updateProductContainer(products) {
  const container = document.querySelector(".grid-wrapper");
  container.innerHTML = ""; // Clear current products

  products.forEach((product) => {
    const productCard = document.createElement("div");

    // Randomly assign a class
    const randomClass = Math.random();
    if (randomClass < 0.33) {
      productCard.classList.add("tall");
    } else if (randomClass < 0.66) {
      productCard.classList.add("big");
    }

    productCard.onclick = product_page; // Assuming product_page is a function you've defined

    const productImage = product.image
      ? `/img/${product.image}`
      : "path_to_default_image.jpg"; // Replace with your default image path

    productCard.innerHTML = `
            <img src="${productImage}" alt="${product.product_name}">
            <div class="item-info">
                <p>${product.product_name}</p>
                <span>${product.price}€</span>
            </div>
        `;

    container.appendChild(productCard);
  });
}
