<?php
include '../../Configuration/config.php';

if (isset($_GET['id'])) {
    $id_command = $_GET['id'];
    $sql = "SELECT * FROM command WHERE id_command = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_command);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $command = $result->fetch_assoc();
    } else {
        echo "Commande non trouvée.";
        exit;
    }
} else {
    echo "Aucun ID de commande spécifié.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_user']) && isset($_POST['id_address'])) {
    $id_user = $_POST['id_user'];
    $id_address = $_POST['id_address'];
    $total_price = $_POST['total_price'];
    $status = $_POST['status'];

    $sql = "UPDATE command SET id_user = ?, id_address = ?, total_price = ?, status = ? WHERE id_command = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iidsi", $id_user, $id_address, $total_price, $status, $id_command);

    if ($stmt->execute()) {
        echo "Commande mise à jour avec succès!";
        header("Location: command.php");
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
    <title>Modifier la Commande</title>
</head>
<body>
    <h1>Modifier la Commande</h1>
    <form method="POST" action="">
        <label for="id_user">ID Utilisateur :</label>
        <input type="number" id="id_user" name="id_user" value="<?php echo htmlspecialchars($command['id_user']); ?>" required><br>

        <label for="id_address">ID Adresse :</label>
        <input type="number" id="id_address" name="id_address" value="<?php echo htmlspecialchars($command['id_address']); ?>" required><br>

        <label for="total_price">Prix Total :</label>
        <input type="number" step="0.01" id="total_price" name="total_price" value="<?php echo htmlspecialchars($command['total_price']); ?>"><br>

        <label for="status">Statut :</label>
        <select id="status" name="status" required>
            <option value="pending" <?php if ($command['status'] == 'pending') echo 'selected'; ?>>En attente</option>
            <option value="shipped" <?php if ($command['status'] == 'shipped') echo 'selected'; ?>>Expédiée</option>
            <option value
