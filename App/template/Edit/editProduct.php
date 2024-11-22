<?php
include '../../Configuration/config.php';

if (isset($_GET['id'])) {
    $id_product = $_GET['id'];
    $sql = "SELECT * FROM product WHERE id_product = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_product);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "Produit non trouvé.";
        exit;
    }
} else {
    echo "Aucun ID de produit spécifié.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name'], $_POST['description'], $_POST['price'], $_POST['stock_quantity'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock_quantity = $_POST['stock_quantity'];

    $sql = "UPDATE product SET name=?, description=?, price=?, stock_quantity=? WHERE id_product=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdii", $name, $description, $price, $stock_quantity, $id_product);
    
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
    <title>Modifier le Produit</title>
    <link rel="stylesheet" href="../../CSS/edit.css">
</head>
<body>
    <h1>Modifier le Produit</h1>
    <form method="POST" action="">
        <label for="name">Nom :</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required><br>

        <label for="description">Description :</label>
        <textarea id="description" name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea><br>

        <label for="price">Prix :</label>
        <input type="number" step="0.01" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required><br>

        <label for="stock_quantity">Quantité en stock :</label>
        <input type="number" id="stock_quantity" name="stock_quantity" value="<?php echo htmlspecialchars($product['stock_quantity']); ?>" required><br>

        <button type="submit">Mettre à jour</button>
    </form>

    <button onclick="window.history.back()">Retour</button>
</body>
</html>
