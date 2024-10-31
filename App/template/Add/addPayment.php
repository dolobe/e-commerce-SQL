<?php
include '../../Configuration/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = $_POST['id_user'];
    $payment_type = $_POST['payment_type'];
    $payment_info = $_POST['payment_info'];

    $sql = "INSERT INTO payment (id_user, payment_type, payment_info) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $id_user, $payment_type, $payment_info);

    if ($stmt->execute()) {
        echo "Paiement ajouté avec succès!";
        header("Location: payment.php");
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
    <title>Ajouter un Paiement</title>
</head>
<body>
    <h1>Ajouter un Paiement</h1>
    <form method="POST" action="">
        <label for="id_user">ID Utilisateur :</label>
        <input type="number" id="id_user" name="id_user" required><br>

        <label for="payment_type">Type de Paiement :</label>
        <select id="payment_type" name="payment_type" required>
            <option value="Credit Card">Carte de Crédit</option>
            <option value="IBAN">IBAN</option>
        </select><br>

        <label for="payment_info">Informations de Paiement :</label>
        <input type="text" id="payment_info" name="payment_info" required><br>
        
        <button type="submit">Ajouter le Paiement</button>
    </form>

    <p><a href="payment.php">Retour à la liste des paiements</a></p>
</body>
</html>
