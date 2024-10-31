<?php
include '../Configuration/config.php';

// Supprimer une évaluation si un ID de suppression est fourni
if (isset($_GET['delete_id'])) {
    $id_rate = $_GET['delete_id'];
    $sql = "DELETE FROM rate WHERE id_rate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_rate);
    
    if ($stmt->execute()) {
        echo "Évaluation supprimée avec succès!";
        header("Location: rate.php");
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
    <title>Liste des Évaluations</title>
</head>
<body>
    <h1>Liste des Évaluations</h1>
    <p><a href="Add/addRate.php">Ajouter une Évaluation</a></p>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>ID Utilisateur</th>
            <th>ID Produit</th>
            <th>Note</th>
            <th>Commentaire</th>
            <th>Action</th>
        </tr>
        <?php
        $sql = "SELECT * FROM rate";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id_rate']}</td>
                        <td>{$row['id_user']}</td>
                        <td>{$row['id_product']}</td>
                        <td>{$row['rating']}</td>
                        <td>{$row['comment']}</td>
                        <td>
                            <a href='Edit/editRate.php?id={$row['id_rate']}'>Modifier</a>
                            |
                            <a href='?delete_id={$row['id_rate']}' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cette évaluation ?\");'>Supprimer</a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Aucune évaluation trouvée</td></tr>";
        }
        ?>
    </table>
</body>
</html>
