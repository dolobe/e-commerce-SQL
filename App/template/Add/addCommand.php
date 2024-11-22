<?php
include '../../Configuration/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = $_POST['id_user'];
    $id_address = $_POST['id_address'];
    $total_price = $_POST['total_price'];
    $status = $_POST['status'];

    $sql = "INSERT INTO command (id_user, id_address, total_price, status) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iids", $id_user, $id_address, $total_price, $status);

    if ($stmt->execute()) {
        echo "Nouvelle commande créée avec succès!";
        header("Location: command.php");
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
    <title>Ajouter une Commande</title>
    <link rel="stylesheet" href="../../CSS/add.css">
</head>
<body>
    <h1>Ajouter une Commande</h1>
    <form method="POST" action="">
        <label for="id_user">ID Utilisateur :</label>
        <input type="number" id="id_user" name="id_user" required><br>
        
        <label for="id_address">ID Adresse :</label>
        <input type="number" id="id_address" name="id_address" required><br>

        <label for="total_price">Prix Total :</label>
        <input type="number" step="0.01" id="total_price" name="total_price"><br>

        <label for="status">Statut :</label>
        <select id="status" name="status" required>
            <option value="pending">En attente</option>
            <option value="shipped">Expédiée</option>
            <option value="delivered">Livrée</option>
        </select><br>
        
        <button type="submit">Ajouter la Commande</button>
    </form>
    
    <button onclick="window.history.back()">Retour</button>
</body>
</html>
