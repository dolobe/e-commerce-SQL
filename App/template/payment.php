<?php
include '../Configuration/config.php';

// Supprimer un paiement si un ID de suppression est fourni
if (isset($_GET['delete_id'])) {
    $id_payment = $_GET['delete_id'];
    $sql = "DELETE FROM payment WHERE id_payment = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_payment);
    
    if ($stmt->execute()) {
        echo "Paiement supprimé avec succès!";
        header("Location: payment.php");
        exit;
    } else {
        echo "Erreur lors de la suppression: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Paiements</title>
</head>
<body>
    <h1>Liste des Paiements</h1>
    <p><a href="Add/addPayment.php">Ajouter un Paiement</a></p>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>ID Utilisateur</th>
            <th>Type de Paiement</th>
            <th>Informations de Paiement</th>
            <th>Action</th>
        </tr>
        <?php
        $sql = "SELECT * FROM payment";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id_payment']}</td>
                        <td>{$row['id_user']}</td>
                        <td>{$row['payment_type']}</td>
                        <td>{$row['payment_info']}</td>
                        <td>
                            <a href='Edit/editPayment.php?id={$row['id_payment']}'>Modifier</a>
                            |
                            <a href='?delete_id={$row['id_payment']}' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer ce paiement ?\");'>Supprimer</a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Aucun paiement trouvé</td></tr>";
        }
        ?>
    </table>
</body>
</html>
