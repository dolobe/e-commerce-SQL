<?php
include 'config.php';

if (isset($_GET['delete_id'])) {
    $id_user = $_GET['delete_id'];
    $sql = "DELETE FROM Users WHERE id_user = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_user);
    
    if ($stmt->execute()) {
        echo "Utilisateur supprimé avec succès!";
        header("Location: index.php");
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
    <title>Mon Application PHP</title>
</head>
<body>
    <h1>Bienvenue dans mon application PHP</h1>
    <p><a href="register.php">S'inscrire</a></p>

    <h2>Liste des utilisateurs</h2>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nom d'utilisateur</th>
            <th>Email</th>
            <th>Date de création</th>
            <th>Action</th>
        </tr>
        <?php
        $sql = "SELECT * FROM Users";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id_user']}</td>
                        <td>{$row['username']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['created_at']}</td>
                        <td>
                            <a href='edit.php?id={$row['id_user']}'>Modifier</a>
                            |
                            <a href='?delete_id={$row['id_user']}' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cet utilisateur ?\");'>Supprimer</a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Aucun utilisateur trouvé</td></tr>";
        }
        ?>
    </table>
</body>
</html>
