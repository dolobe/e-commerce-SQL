<?php
include '../Configuration/config.php';

if (isset($_GET['delete_id'])) {
    $id_cart_product = $_GET['delete_id'];
    $sql = "DELETE FROM cart_product WHERE id_cart_product = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_cart_product);

    if ($stmt->execute()) {
        echo "Produit supprimé du panier avec succès!";
        header("Location: cart_product.php");
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
    <title>Produits dans le Panier</title>
</head>
<body>
    <h1>Liste des Produits dans le Panier</h1>
    <p><a href="Add/addCartProduct.php">Ajouter un Produit au Panier</a></p>

    <table border="1">
        <tr>
            <th>ID Cart Product</th>
            <th>ID Panier</th>
            <th>ID Produit</th>
            <th>Quantité</th>
            <th>Action</th>
        </tr>
        <?php
        $sql = "SELECT * FROM cart_product";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id_cart_product']}</td>
                        <td>{$row['id_cart']}</td>
                        <td>{$row['id_product']}</td>
                        <td>{$row['quantity']}</td>
                        <td>
                            <a href='Edit/editCartProduct.php?id={$row['id_cart_product']}'>Modifier</a> 
                            |
                            <a href='?delete_id={$row['id_cart_product']}' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer ce produit du panier ?\");'>Supprimer</a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Aucun produit trouvé dans le panier</td></tr>";
        }
        ?>
    </table>
</body>
</html>
