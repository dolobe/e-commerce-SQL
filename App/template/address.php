<?php
include '../Configuration/config.php';

$search_term = "";

if (isset($_GET['search'])) {
    $search_term = $_GET['search'];
    $sql = "SELECT * FROM address WHERE street LIKE ? OR city LIKE ? OR postal_code LIKE ?";
    $stmt = $conn->prepare($sql);
    $search_term = "%" . $search_term . "%";
    $stmt->bind_param("sss", $search_term, $search_term, $search_term);
} else {
    $sql = "SELECT * FROM address";
    $stmt = $conn->prepare($sql);
}

$stmt->execute();
$result = $stmt->get_result();

if (isset($_GET['delete_id'])) {
    $id_address = $_GET['delete_id'];
    $sql = "DELETE FROM address WHERE id_address = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_address);
    
    if ($stmt->execute()) {
        echo "<script>alert('Adresse supprimée avec succès!');</script>";
        header("Location: address.php");
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
    <title>Gestion des Adresses</title>
</head>
<body>
    <h1>Liste des Adresses</h1>
    
    <form method="GET" action="">
        <input type="text" name="search" value="<?php echo htmlspecialchars($search_term); ?>" placeholder="Rechercher par rue, ville ou code postal" />
        <button type="submit">Rechercher</button>
    </form>

    <p><a href="Add/addAddress.php">Ajouter une adresse</a></p>

    <h2>Adresses</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>ID Utilisateur</th>
            <th>Rue</th>
            <th>Ville</th>
            <th>Code Postal</th>
            <th>Pays</th>
            <th>Action</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id_address']}</td>
                        <td>{$row['id_user']}</td>
                        <td>{$row['street']}</td>
                        <td>{$row['city']}</td>
                        <td>{$row['postal_code']}</td>
                        <td>{$row['country']}</td>
                        <td>
                            <a href='Edit/editAddress.php?id={$row['id_address']}'>Modifier</a>
                            |
                            <a href='?delete_id={$row['id_address']}' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cette adresse ?\");'>Supprimer</a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Aucune adresse trouvée</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php
$conn->close();
?>
