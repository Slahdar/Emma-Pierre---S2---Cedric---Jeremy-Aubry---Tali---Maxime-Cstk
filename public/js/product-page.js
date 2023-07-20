const btnAddCart = document.getElementById("addCart");
const qtyProduct = document.getElementById("qty_product");

btnAddCart.addEventListener("click", function () {
  let id_product = btnAddCart.value;
  let qty_product = qtyProduct.value;

  fetch(`/api/addCart/${id_product}/${qty_product}`, { method: "POST" })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        alert("Le produit a été ajouté au panier avec succès !");
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
