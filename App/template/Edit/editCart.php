<?php
include '../../Configuration/config.php';

if (isset($_GET['id'])) {
    $id_cart = $_GET['id'];
    $sql = "SELECT * FROM cart WHERE id_cart = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_cart);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $cart = $result->fetch_assoc();
    } else {
        echo "Panier non trouvé.";
        exit;
    }
} else {
    echo "Aucun ID de panier spécifié.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_user'])) {
    $id_user = $_POST['id_user'];

    $sql = "UPDATE cart SET id_user = ? WHERE id_cart = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_user, $id_cart);

    if ($stmt->execute()) {
        echo "Panier mis à jour avec succès!";
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
    <title>Modifier le Panier</title>
    <link rel="stylesheet" href="../../CSS/edit.css">
</head>
<body>
    <h1>Modifier le Panier</h1>
    <form method="POST" action="">
        <label for="id_user">ID Utilisateur :</label>
        <input type="number" id="id_user" name="id_user" value="<?php echo htmlspecialchars($cart['id_user']); ?>" required><br>
        
        <button type="submit">Mettre à jour</button>
    </form>

    <p><a href="cart.php">Retour à la liste des paniers</a></p>
</body>
</html>
