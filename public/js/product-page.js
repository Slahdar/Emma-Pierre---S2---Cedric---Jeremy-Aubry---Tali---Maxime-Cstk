const btnAddCart = document.getElementById("addCart");

btnAddCart.addEventListener("click", function () {
  let id_product = btnAddCart.value;

  fetch(`/api/addCart/${id_product}`)
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        alert("Le produit a été ajouté au panier avec succès !");
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
