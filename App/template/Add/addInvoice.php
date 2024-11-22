<?php
include '../../Configuration/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_command = $_POST['id_command'];
    $total_price = $_POST['total_price'];

    $sql = "INSERT INTO invoice (id_command, total_price) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("id", $id_command, $total_price);

    if ($stmt->execute()) {
        echo "Nouvelle facture créée avec succès!";
        header("Location: invoice.php");
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
    <title>Ajouter une Facture</title>
    <link rel="stylesheet" href="../../CSS/add.css">
</head>
<body>
    <h1>Ajouter une Facture</h1>
    <form method="POST" action="">
        <label for="id_command">ID Commande :</label>
        <input type="number" id="id_command" name="id_command" required><br>

        <label for="total_price">Prix Total :</label>
        <input type="number" step="0.01" id="total_price" name="total_price"><br>
        
        <button type="submit">Ajouter la Facture</button>
    </form>
    
    <button onclick="window.history.back()">Retour</button>
</body>
</html>
