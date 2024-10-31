<?php
include '../../Configuration/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_cart = $_POST['id_cart'];
    $id_product = $_POST['id_product'];
    $quantity = $_POST['quantity'];

    $sql = "INSERT INTO cart_product (id_cart, id_product, quantity) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $id_cart, $id_product, $quantity);

    if ($stmt->execute()) {
        echo "Produit ajouté au panier avec succès!";
        header("Location: cart_product.php");
        exit;
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
    <title>Ajouter un Produit au Panier</title>
</head>
<body>
    <h1>Ajouter un Produit au Panier</h1>
    <form method="POST" action="">
        <label for="id_cart">ID Panier :</label>
        <input type="number" id="id_cart" name="id_cart" required><br>

        <label for="id_product">ID Produit :</label>
        <input type="number" id="id_product" name="id_product" required><br>

        <label for="quantity">Quantité :</label>
        <input type="number" id="quantity" name="quantity" min="1" required><br>
        
        <button type="submit">Ajouter au Panier</button>
    </form>
    
    <button onclick="window.history.back()">Retour</button>
</body>
</html>
