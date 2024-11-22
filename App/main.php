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
            background: linear-gradient(to right, #0f2027, #203a43, #2c5364);
            color: #ffffff;
            margin: 0;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        h1 {
            text-align: center;
            color: #ffffff;
            font-size: 2rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4);
            margin-bottom: 20px;
        }

        .container {
            max-width: 600px;
            padding: 40px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        .button {
            display: inline-block;
            padding: 12px 24px;
            margin: 10px;
            background-color: #00aaff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            font-size: 1rem;
            transition: background-color 0.3s ease, transform 0.3s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        }

        .button:hover {
            background-color: #66d9ff;
            transform: scale(1.05);
        }

        .button:active {
            background-color: #0056b3;
            transform: scale(0.98);
        }

        p a {
            background-color: #00aaff;
            color: #ffffff;
            padding: 12px 24px;
            border-radius: 8px;
            text-transform: uppercase;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        p a:hover {
            background-color: #66d9ff;
            transform: scale(1.05);
        }

        p a:active {
            background-color: #0056b3;
            transform: scale(0.98);
        }

        p {
            margin: 10px 0;
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
