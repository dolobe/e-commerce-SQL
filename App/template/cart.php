<?php
include '../Configuration/config.php';

if (isset($_GET['delete_id'])) {
    $id_cart = $_GET['delete_id'];
    $sql = "DELETE FROM cart WHERE id_cart = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_cart);
    
    if ($stmt->execute()) {
        echo "Panier supprimé avec succès!";
        header("Location: cart.php");
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
    <title>Gestion des Paniers</title>
</head>
<body>
    <h1>Liste des Paniers</h1>
    <p><a href="Add/addCart.php">Ajouter un Panier</a></p>

    <table border="1">
        <tr>
            <th>ID Panier</th>
            <th>ID Utilisateur</th>
            <th>Date de Création</th>
            <th>Action</th>
        </tr>
        <?php
        $sql = "SELECT * FROM cart";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id_cart']}</td>
                        <td>{$row['id_user']}</td>
                        <td>{$row['created_at']}</td>
                        <td>
                            <a href='Edit/editCart.php?id={$row['id_cart']}'>Modifier</a> 
                            |
                            <a href='?delete_id={$row['id_cart']}' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer ce panier ?\");'>Supprimer</a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>Aucun panier trouvé</td></tr>";
        }
        ?>
    </table>
</body>
</html>
