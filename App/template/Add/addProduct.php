<?php
include '../../Configuration/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock_quantity = $_POST['stock_quantity'];

    $sql = "INSERT INTO product (name, description, price, stock_quantity) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdi", $name, $description, $price, $stock_quantity);
    
    if ($stmt->execute()) {
        echo "Nouveau produit créé avec succès!";
    } else {
        echo "Erreur: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Produit</title>
</head>
<body>
    <h1>Ajouter un Produit</h1>
    <form method="POST" action="">
        <label for="name">Nom :</label>
        <input type="text" id="name" name="name" required><br>

        <label for="description">Description :</label>
        <textarea id="description" name="description" required></textarea><br>

        <label for="price">Prix :</label>
        <input type="number" step="0.01" id="price" name="price" required><br>

        <label for="stock_quantity">Quantité en stock :</label>
        <input type="number" id="stock_quantity" name="stock_quantity" required><br>

        <button type="submit">Ajouter le produit</button>
    </form>
    
    <button onclick="window.history.back()">Retour</button>
</body>
</html>
