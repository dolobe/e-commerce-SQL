<?php
include '../../Configuration/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = $_POST['id_user'];

    $sql = "INSERT INTO cart (id_user) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_user);

    if ($stmt->execute()) {
        echo "Nouveau panier créé avec succès!";
        header("Location: cart.php");
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
    <title>Ajouter un Panier</title>
</head>
<body>
    <h1>Ajouter un Panier</h1>
    <form method="POST" action="">
        <label for="id_user">ID Utilisateur :</label>
        <input type="number" id="id_user" name="id_user" required><br>
        
        <button type="submit">Ajouter le Panier</button>
    </form>
    
    <button onclick="window.history.back()">Retour</button>
</body>
</html>
