<?php
include '../../Configuration/config.php';

if (isset($_GET['id'])) {
    $id_payment = $_GET['id'];
    $sql = "SELECT * FROM payment WHERE id_payment = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_payment);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $payment = $result->fetch_assoc();
    } else {
        echo "Paiement non trouvé.";
        exit;
    }
} else {
    echo "Aucun ID de paiement spécifié.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = $_POST['id_user'];
    $payment_type = $_POST['payment_type'];
    $payment_info = $_POST['payment_info'];

    $sql = "UPDATE payment SET id_user=?, payment_type=?, payment_info=? WHERE id_payment=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issi", $id_user, $payment_type, $payment_info, $id_payment);
    
    if ($stmt->execute()) {
        echo "Paiement mis à jour avec succès!";
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
    <title>Modifier le Paiement</title>
    <link rel="stylesheet" href="../../CSS/edit.css">
</head>
<body>
    <h1>Modifier le Paiement</h1>
    <form method="POST" action="">
        <label for="id_user">ID Utilisateur :</label>
        <input type="number" id="id_user" name="id_user" value="<?php echo isset($payment['id_user']) ? htmlspecialchars($payment['id_user']) : ''; ?>" required><br>

        <label for="payment_type">Type de Paiement :</label>
        <select id="payment_type" name="payment_type" required>
            <option value="Credit Card" <?php echo ($payment['payment_type'] == 'Credit Card') ? 'selected' : ''; ?>>Carte de Crédit</option>
            <option value="IBAN" <?php echo ($payment['payment_type'] == 'IBAN') ? 'selected' : ''; ?>>IBAN</option>
        </select><br>

        <label for="payment_info">Informations de Paiement :</label>
        <input type="text" id="payment_info" name="payment_info" value="<?php echo isset($payment['payment_info']) ? htmlspecialchars($payment['payment_info']) : ''; ?>" required><br>
        
        <button type="submit">Mettre à jour le Paiement</button>
    </form>

    <button onclick="window.history.back()">Retour</button>
</body>
</html>
