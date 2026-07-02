# Nomad Spirit Store

Projet de fin de module (OFPPT - Développement Digital).

C'est un site e-commerce pour vendre des vêtements et accessoires traditionnels sahraouis (melhfas, turbans, accessoires). Fait en PHP et MySQL, sans framework, avec une architecture MVC simple.

## Ce que le site fait

- Voir les produits par catégorie (femmes, hommes, accessoires)
- Créer un compte / se connecter
- Ajouter des produits au panier et passer commande
- Un espace admin pour gérer les produits, catégories, commandes et utilisateurs

## Comment le lancer

1. Mettre le dossier dans `htdocs` (XAMPP)
2. Démarrer Apache et MySQL dans XAMPP
3. Importer `database.sql` dans phpMyAdmin pour créer la base
4. Copier `.env.example` et renommer en `.env`, mettre ses propres identifiants MySQL dedans
5. Ouvrir `http://localhost/monsite/my_project`

## Organisation des dossiers

- `config/` - connexion à la base, session, fonctions d'authentification
- `controllers/` - la logique de chaque page
- `models/` - les classes User, Product, Category, Order
- `views/` - le HTML affiché
- `routes.php` - redirige vers le bon contrôleur selon la page demandée
- `index.php` - point d'entrée du site
