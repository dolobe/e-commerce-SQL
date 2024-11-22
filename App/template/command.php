<?php
include '../Configuration/config.php';

if (isset($_GET['delete_id'])) {
    $id_command = $_GET['delete_id'];
    $sql = "DELETE FROM command WHERE id_command = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_command);

    if ($stmt->execute()) {
        echo "Commande supprimée avec succès!";
        header("Location: command.php");
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
    <title>Gestion des Commandes</title>
    <link rel="stylesheet" href="../CSS/table.css">
</head>
<body>
    <h1>Liste des Commandes</h1>
    <p><a href="Add/addCommand.php">Ajouter une Commande</a></p>

    <h2>Rechercher une Commande</h2>
    <form method="GET" action="command.php">
        <input type="text" name="search" placeholder="Rechercher par ID Commande, Utilisateur ou Statut" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
        <button type="submit">Rechercher</button>
    </form>

    <table border="1">
        <tr>
            <th>ID Commande</th>
            <th>ID Utilisateur</th>
            <th>ID Adresse</th>
            <th>Prix Total</th>
            <th>Statut</th>
            <th>Date de Création</th>
            <th>Action</th>
        </tr>
        <?php
        $search = isset($_GET['search']) ? "%" . $_GET['search'] . "%" : "%";
        $sql = "SELECT * FROM command 
                WHERE id_command LIKE ? 
                OR id_user LIKE ? 
                OR status LIKE ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $search, $search, $search);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id_command']}</td>
                        <td>{$row['id_user']}</td>
                        <td>{$row['id_address']}</td>
                        <td>{$row['total_price']}</td>
                        <td>{$row['status']}</td>
                        <td>{$row['created_at']}</td>
                        <td>
                            <a href='Edit/editCommand.php?id={$row['id_command']}'>Modifier</a> 
                            |
                            <a href='?delete_id={$row['id_command']}' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cette commande ?\");'>Supprimer</a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Aucune commande trouvée</td></tr>";
        }
        ?>
    </table>
    <button onclick="window.history.back()">Retour</button>
</body>
</html>
