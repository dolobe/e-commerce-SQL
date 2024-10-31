<?php
include 'Configuration/config.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'accueil - Mon Application PHP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            text-align: center;
        }

        h1 {
            color: #333;
        }

        .button {
            display: inline-block;
            padding: 15px 25px;
            margin: 10px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .button:hover {
            background-color: #0056b3;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bienvenue dans mon application PHP</h1>
        
        <p>
            <a href="template/user.php" class="button">Gérer les Utilisateurs</a>
        </p>
        <p>
            <a href="template/address.php" class="button">Gérer les Adresses</a>
        </p>
        <p>
            <a href="template/product.php" class="button">Gérer les Produits</a>
        </p>
        <p>
            <a href="template/cart.php" class="button">Gérer les Carts</a>
        </p>
        <p>
            <a href="template/command.php" class="button">Gérer les Commandes</a>
        </p>
        <p>
            <a href="template/invoice.php" class="button">Gérer les Factures</a>
        </p>
        <p>
            <a href="template/cart_product.php" class="button">Gérer les Produits du Panier</a>
        </p>
        <p>
            <a href="template/command_product.php" class="button">Gérer les Produits de Commande</a>
        </p>
        <p>
            <a href="template/photo.php" class="button">Gérer les Photos</a>
        </p>
        <p>
            <a href="template/rate.php" class="button">Gérer les Notes</a>
        </p>
        <p>
            <a href="template/payment.php" class="button">Gérer les Paiements</a>
        </p>
        
        <p>
            <a href="main.php" class="button">Retour à l'accueil</a>
        </p>
    </div>
</body>
</html>
