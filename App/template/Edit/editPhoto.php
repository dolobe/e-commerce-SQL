<?php
include '../../Configuration/config.php';

if (isset($_GET['id'])) {
    $id_photo = $_GET['id'];
    $sql = "SELECT * FROM photo WHERE id_photo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_photo);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $photo = $result->fetch_assoc();
    } else {
        echo "Photo non trouvée.";
        exit;
    }
} else {
    echo "Aucun ID de photo spécifié.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = $_POST['id_user'];
    $id_product = $_POST['id_product'];
    $photo_url = $_POST['photo_url'];

    $sql = "UPDATE photo SET id_user = ?, id_product = ?, photo_url = ? WHERE id_photo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisi", $id_user, $id_product, $photo_url, $id_photo);

    if ($stmt->execute()) {
        echo "Photo mise à jour avec succès!";
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
    <title>Modifier la Photo</title>
    <link rel="stylesheet" href="../../CSS/edit.css">
</head>
<body>
    <h1>Modifier la Photo</h1>
    <form method="POST" action="">
        <label for="id_user">ID Utilisateur :</label>
        <input type="number" id="id_user" name="id_user" value="<?php echo htmlspecialchars($photo['id_user']); ?>"><br>

        <label for="id_product">ID Produit :</label>
        <input type="number" id="id_product" name="id_product" value="<?php echo htmlspecialchars($photo['id_product']); ?>"><br>

        <label for="photo_url">URL de la Photo :</label>
        <input type="text" id="photo_url" name="photo_url" value="<?php echo htmlspecialchars($photo['photo_url']); ?>" required><br>
        
        <button type="submit">Mettre à jour</button>
    </form>
    <button onclick="window.history.back()">Retour</button>

    <p
