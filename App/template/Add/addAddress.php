<?php
include '../../Configuration/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = $_POST['id_user'];
    $street = $_POST['street'];
    $city = $_POST['city'];
    $postal_code = $_POST['postal_code'];
    $country = $_POST['country'];

    if (empty($street) || empty($city) || empty($postal_code) || empty($country) || empty($id_user)) {
        echo "Tous les champs sont obligatoires.";
        exit;
    }

    $sql = "INSERT INTO address (id_user, street, city, postal_code, country) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $id_user, $street, $city, $postal_code, $country);

    if ($stmt->execute()) {
        echo "Adresse ajoutée avec succès!";
        header("Location: address.php");
        exit;
    } else {
        echo "Erreur lors de l'ajout de l'adresse: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une adresse</title>
    <link rel="stylesheet" href="../../CSS/add.css">
</head>
<body>
    <h1>Ajouter une nouvelle adresse</h1>
    <form method="POST" action="">
        <label for="id_user">ID Utilisateur :</label>
        <input type="number" id="id_user" name="id_user" required><br>

        <label for="street">Rue :</label>
        <input type="text" id="street" name="street" required><br>

        <label for="city">Ville :</label>
        <input type="text" id="city" name="city" required><br>

        <label for="postal_code">Code Postal :</label>
        <input type="text" id="postal_code" name="postal_code" required><br>

        <label for="country">Pays :</label>
        <input type="text" id="country" name="country" required><br>

        <button type="submit">Ajouter l'adresse</button>
    </form>

    <p><a href="address.php">Retour à la liste des adresses</a></p>
</body>
</html>
