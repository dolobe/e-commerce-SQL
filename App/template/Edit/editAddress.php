<?php
include '../../Configuration/config.php';

if (isset($_GET['id'])) {
    $id_address = $_GET['id'];
    $sql = "SELECT * FROM address WHERE id_address = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_address);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $address = $result->fetch_assoc();
    } else {
        echo "Adresse non trouvée.";
        exit;
    }
} else {
    echo "Aucun ID d'adresse spécifié.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['street']) && isset($_POST['city']) && isset($_POST['postal_code']) && isset($_POST['country'])) {
    $street = $_POST['street'];
    $city = $_POST['city'];
    $postal_code = $_POST['postal_code'];
    $country = $_POST['country'];

    if (empty($street) || empty($city) || empty($postal_code) || empty($country)) {
        echo "Tous les champs sont obligatoires.";
        exit;
    }

    $sql = "UPDATE address SET street=?, city=?, postal_code=?, country=? WHERE id_address=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $street, $city, $postal_code, $country, $id_address);
    
    if ($stmt->execute()) {
        echo "Adresse mise à jour avec succès!";
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
    <title>Modifier l'adresse</title>
    <link rel="stylesheet" href="../../CSS/edit.css">
</head>
<body>
    <h1>Modifier l'adresse</h1>
    <form method="POST" action="">
        <label for="street">Rue :</label>
        <input type="text" id="street" name="street" value="<?php echo isset($address['street']) ? htmlspecialchars($address['street']) : ''; ?>" required><br>
        
        <label for="city">Ville :</label>
        <input type="text" id="city" name="city" value="<?php echo isset($address['city']) ? htmlspecialchars($address['city']) : ''; ?>" required><br>
        
        <label for="postal_code">Code Postal :</label>
        <input type="text" id="postal_code" name="postal_code" value="<?php echo isset($address['postal_code']) ? htmlspecialchars($address['postal_code']) : ''; ?>" required><br>
        
        <label for="country">Pays :</label>
        <input type="text" id="country" name="country" value="<?php echo isset($address['country']) ? htmlspecialchars($address['country']) : ''; ?>" required><br>
        
        <button type="submit">Mettre à jour</button>
    </form>

    <button onclick="window.history.back()">Retour</button>
</body>
</html>
