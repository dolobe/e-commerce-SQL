<?php
include '../../Configuration/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_command = $_POST['id_command'];
    $id_product = $_POST['id_product'];
    $quantity = $_POST['quantity'];

    $sql = "INSERT INTO command_product (id_command, id_product, quantity) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $id_command, $id_product, $quantity);

    if ($stmt->execute()) {
        echo "Produit ajouté à la commande avec succès!";
        header("Location: command_product.php");
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
    <title>Ajouter un Produit à la Commande</title>
</head>
<body>
    <h1>Ajouter un Produit à la Commande</h1>
    <form method="POST" action="">
        <label for="id_command">ID Commande :</label>
        <input type="number" id="id_command" name="id_command" required><br>

        <label for="id_product">ID Produit :</label>
        <input type="number" id="id_product" name="id_product" required><br>

        <label for="quantity">Quantité :</label>
        <input type="number" id="quantity" name="quantity" min="1" required><br>
        
        <button type="submit">Ajouter à la Commande</button>
    </form>
    
    <button onclick="window.history.back()">Retour</button>
</body>
</html>
