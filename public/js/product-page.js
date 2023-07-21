const btnAddCart = document.getElementById("addCart");
const qtyProduct = document.getElementById("qty_product");

btnAddCart.addEventListener("click", function () {
  let id_product = btnAddCart.value;
  let qty_product = qtyProduct.value;

  fetch(`/api/addCart/${id_product}/${qty_product}`, { method: "POST" })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {

        const cartButton = document.getElementById('cart-btn');

        // Add the styles using JavaScript
        cartButton.style.background = '#ff000082';
        cartButton.style.borderRadius = '5px';
        cartButton.style.padding = '5px';
        cartButton.style.transition = 'background 0.3s, border-radius 0.3s, padding 0.3s';




        // Function to reset the styles to their initial values
        function resetStyles() {
          cartButton.style.background = '#ffff';
          cartButton.style.borderRadius = '0';
        }

        // Add a click event listener to the div
        cartButton.addEventListener('click', function () {


          // Use setTimeout to reset the styles after the transition is completed (adjust the delay based on your transition duration)
          setTimeout(resetStyles, 300);
        });

        refreshCart();
      } else {
        alert(
          "Une erreur s'est produite lors de l'ajout du produit au panier."
        );
      }
    })
    .catch((error) => {
      console.error("There was an error fetching the products:", error);
    });
});
