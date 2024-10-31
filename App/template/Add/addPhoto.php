<?php
include '../../Configuration/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = $_POST['id_user'];
    $id_product = $_POST['id_product'];
    $photo_url = $_POST['photo_url'];

    $sql = "INSERT INTO photo (id_user, id_product, photo_url) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iis", $id_user, $id_product, $photo_url);

    if ($stmt->execute()) {
        echo "Photo ajoutée avec succès!";
        header("Location: photo.php");
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
    <title>Ajouter une Photo</title>
</head>
<body>
    <h1>Ajouter une Photo</h1>
    <form method="POST" action="">
        <label for="id_user">ID Utilisateur :</label>
        <input type="number" id="id_user" name="id_user"><br>

        <label for="id_product">ID Produit :</label>
        <input type="number" id="id_product" name="id_product"><br>

        <label for="photo_url">URL de la Photo :</label>
        <input type="text" id="photo_url" name="photo_url" required><br>
        
        <button type="submit">Ajouter la Photo</button>
    </form>

    <button onclick="window.history.back()">Retour</button>
</body>
</html>
