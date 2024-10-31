<?php
include '../Configuration/config.php';

if (isset($_GET['delete_id'])) {
    $id_product = $_GET['delete_id'];
    $sql = "DELETE FROM product WHERE id_product = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_product);
    
    if ($stmt->execute()) {
        echo "Produit supprimé avec succès!";
        header("Location: product.php");
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
    <title>Gestion des Produits</title>
</head>
<body>
    <h1>Liste des Produits</h1>
    <p><a href="Add/addProduct.php">Ajouter un produit</a></p>

    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Description</th>
            <th>Prix</th>
            <th>Quantité en stock</th>
            <th>Action</th>
        </tr>
        <?php
        $sql = "SELECT * FROM product";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id_product']}</td>
                        <td>{$row['name']}</td>
                        <td>{$row['description']}</td>
                        <td>{$row['price']}</td>
                        <td>{$row['stock_quantity']}</td>
                        <td>
                            <a href='Edit/editProduct.php?id={$row['id_product']}'>Modifier</a> |
                            <a href='?delete_id={$row['id_product']}' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer ce produit ?\");'>Supprimer</a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Aucun produit trouvé</td></tr>";
        }
        ?>
    </table>
</body>
</html>
