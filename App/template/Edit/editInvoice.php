<?php
include '../../Configuration/config.php';

if (isset($_GET['id'])) {
    $id_invoice = $_GET['id'];
    $sql = "SELECT * FROM invoice WHERE id_invoice = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_invoice);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $invoice = $result->fetch_assoc();
    } else {
        echo "Facture non trouvée.";
        exit;
    }
} else {
    echo "Aucun ID de facture spécifié.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_command']) && isset($_POST['total_price'])) {
    $id_command = $_POST['id_command'];
    $total_price = $_POST['total_price'];

    $sql = "UPDATE invoice SET id_command = ?, total_price = ? WHERE id_invoice = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("idi", $id_command, $total_price, $id_invoice);

    if ($stmt->execute()) {
        echo "Facture mise à jour avec succès!";
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
    <title>Modifier la Facture</title>
</head>
<body>
    <h1>Modifier la Facture</h1>
    <form method="POST" action="">
        <label for="id_command">ID Commande :</label>
        <input type="number" id="id_command" name="id_command" value="<?php echo htmlspecialchars($invoice['id_command']); ?>" required><br>

        <label for="total_price">Prix Total :</label>
        <input type="number" step="0.01" id="total_price" name="total_price" value="<?php echo htmlspecialchars($invoice['total_price']); ?>"><br>
        
        <button type="submit">Mettre à jour</button>
    </form>

    <p><a href="invoice.php">Retour à la liste des factures</a></p>
</body>
</html>
