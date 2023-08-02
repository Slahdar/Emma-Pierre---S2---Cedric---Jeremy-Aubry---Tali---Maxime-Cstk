# EMMA PIERRE : E-commerce avec PHP (MVC)

Bienvenue sur le projet "EMMA PIERRE". Il s'agit d'une application e-commerce réalisée à l'aide d'une architecture MVC simple en PHP.

## Fonctionnalités Principales

- **Catalogue produit** : Permet de consulter la liste des produits disponibles.
- **Page produit** : Détails spécifiques de chaque produit.
- **Panier** : Ajoutez, consultez et modifiez les articles de votre panier.
- **Backend Admin** : Une interface d'administration pour :
  - Consulter les produits du site.
  - Ajouter de nouveaux produits.
  - Supprimer des produits existants.
  - Visualiser les commandes passées par les utilisateurs.

  > **Accès** : L'accès au backend est disponible via l'endpoint `/back` (ex: `localhost:5000/back`). Une authentification en tant qu'administrateur est nécessaire.

## Base de Données

- Une base de données nommée `EmmaPierre.sql` est fournie à la racine du répertoire Git.

## API

Une API a été mise en place pour rendre le site plus dynamique grâce aux appels AJAX. Voici la liste des endpoints disponibles :

- **Produits** :
  - Ajouter un produit : `POST /api/products`
  - Récupérer tous les produits : `GET /api/products`
  - Récupérer un produit spécifique : `GET /api/products/{id}`
  
- **Panier** :
  - Récupérer les articles du panier : `GET /api/cart`
  - Récupérer le total du panier : `GET /api/cart/total`
  - Vider le panier : `GET /api/cart/deleteall`
  - Ajouter un article au panier : `POST /api/addCart/{id}/{qty}`
  - Supprimer un article du panier : `POST /api/cart/delete/{id}`
  - Passer une commande : `POST /api/order`
  
- **Commandes** :
  - Récupérer toutes les commandes : `GET /api/orders`

> **Note** : Certains Endpoints sont réservé aux administrateurs, pour un détail précis sur la logique de chaque endpoint, veuillez vous référer au code source de l'API. (ApiController.php)

## Identifiants de Test

Voici quelques comptes pour tester le site :

- **Utilisateurs** :
  - Pseudo : `john69` / Password : `azerty`
  - Pseudo : `gaet21` / Password : `azerty`

- **Administrateur** :
  - Pseudo : `admin` / Password : `admin`

---

