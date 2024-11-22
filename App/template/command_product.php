<?php
include '../Configuration/config.php';

if (isset($_GET['delete_id'])) {
    $id_command_product = $_GET['delete_id'];
    $sql = "DELETE FROM command_product WHERE id_command_product = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_command_product);

    if ($stmt->execute()) {
        echo "Produit supprimé de la commande avec succès!";
        header("Location: command_product.php");
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
    <title>Produits de la Commande</title>
    <link rel="stylesheet" href="../CSS/table.css">
</head>
<body>
    <h1>Liste des Produits dans la Commande</h1>
    <p><a href="Add/addCommandProduct.php">Ajouter un Produit à la Commande</a></p>

    <h2>Rechercher un Produit dans une Commande</h2>
    <form method="GET" action="command_product.php">
        <input type="text" name="search" placeholder="Rechercher par ID Commande, Produit ou Quantité" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
        <button type="submit">Rechercher</button>
    </form>

    <table border="1">
        <tr>
            <th>ID Command Product</th>
            <th>ID Commande</th>
            <th>ID Produit</th>
            <th>Quantité</th>
            <th>Action</th>
        </tr>
        <?php
        $search = isset($_GET['search']) ? "%" . $_GET['search'] . "%" : "%";
        $sql = "SELECT * FROM command_product 
                WHERE id_command_product LIKE ? 
                OR id_command LIKE ? 
                OR id_product LIKE ? 
                OR quantity LIKE ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $search, $search, $search, $search);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id_command_product']}</td>
                        <td>{$row['id_command']}</td>
                        <td>{$row['id_product']}</td>
                        <td>{$row['quantity']}</td>
                        <td>
                            <a href='Edit/editCommandProduct.php?id={$row['id_command_product']}'>Modifier</a> |
                            <a href='?delete_id={$row['id_command_product']}' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer ce produit de la commande ?\");'>Supprimer</a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Aucun produit trouvé dans la commande</td></tr>";
        }
        ?>
    </table>
    <button onclick="window.history.back()">Retour</button>
</body>
</html>
