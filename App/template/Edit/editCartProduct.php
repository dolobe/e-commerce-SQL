<?php
include '../../Configuration/config.php';

if (isset($_GET['id'])) {
    $id_cart_product = $_GET['id'];
    $sql = "SELECT * FROM cart_product WHERE id_cart_product = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_cart_product);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $cart_product = $result->fetch_assoc();
    } else {
        echo "Produit non trouvé dans le panier.";
        exit;
    }
} else {
    echo "Aucun ID de produit spécifié.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['quantity'])) {
    $quantity = $_POST['quantity'];

    $sql = "UPDATE cart_product SET quantity = ? WHERE id_cart_product = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $quantity, $id_cart_product);

    if ($stmt->execute()) {
        echo "Produit mis à jour avec succès!";
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
    <title>Modifier le Produit dans le Panier</title>
    <link rel="stylesheet" href="../../CSS/edit.css">
</head>
<body>
    <h1>Modifier le Produit dans le Panier</h1>
    <form method="POST" action="">
        <label for="quantity">Quantité :</label>
        <input type="number" id="quantity" name="quantity" value="<?php echo isset($cart_product['quantity']) ? htmlspecialchars($cart_product['quantity']) : ''; ?>" min="1" required><br>
        
        <button type="submit">Mettre à jour</button>
    </form>

    <button onclick="window.history.back()">Retour</button>
</body>
</html>
