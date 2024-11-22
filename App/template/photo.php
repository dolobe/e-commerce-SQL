<?php
include '../Configuration/config.php';

if (isset($_GET['delete_id'])) {
    $id_photo = $_GET['delete_id'];
    $sql = "DELETE FROM photo WHERE id_photo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_photo);

    if ($stmt->execute()) {
        echo "Photo supprimée avec succès!";
        header("Location: photo.php");
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
    <title>Photos</title>
</head>
<body>
    <h1>Liste des Photos</h1>
    <p><a href="Add/addPhoto.php">Ajouter une Photo</a></p>

    <h2>Rechercher une Photo</h2>
    <form method="GET" action="photo.php">
        <input type="text" name="search" placeholder="Rechercher par ID Photo, ID Utilisateur, ID Produit ou URL" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
        <button type="submit">Rechercher</button>
    </form>

    <table border="1">
        <tr>
            <th>ID Photo</th>
            <th>ID Utilisateur</th>
            <th>ID Produit</th>
            <th>URL de la Photo</th>
            <th>Action</th>
        </tr>
        <?php
        $search = isset($_GET['search']) ? "%" . $_GET['search'] . "%" : "%";
        $sql = "SELECT * FROM photo 
                WHERE id_photo LIKE ? 
                OR id_user LIKE ? 
                OR id_product LIKE ? 
                OR photo_url LIKE ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $search, $search, $search, $search);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id_photo']}</td>
                        <td>{$row['id_user']}</td>
                        <td>{$row['id_product']}</td>
                        <td><img src='{$row['photo_url']}' alt='Photo' width='100'></td>
                        <td>
                            <a href='Edit/editPhoto.php?id={$row['id_photo']}'>Modifier</a>
                            |
                            <a href='?delete_id={$row['id_photo']}' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cette photo ?\");'>Supprimer</a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Aucune photo trouvée</td></tr>";
        }
        ?>
    </table>
</body>
</html>
