<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id_user = $_GET['id'];
    $sql = "SELECT * FROM Users WHERE id_user = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "Utilisateur non trouvé.";
        exit;
    }
} else {
    echo "Aucun ID d'utilisateur spécifié.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username']) && isset($_POST['email'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];

    if (empty($username) || empty($email)) {
        echo "Le nom d'utilisateur et l'email ne peuvent pas être vides.";
        exit;
    }

    $sql = "UPDATE Users SET username=?, email=? WHERE id_user=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $username, $email, $id_user);
    
    if ($stmt->execute()) {
        echo "Utilisateur mis à jour avec succès!";
        header("Location: index.php");
        exit;
    } else {
        echo "Erreur: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'utilisateur</title>
</head>
<body>
    <h1>Modifier l'utilisateur</h1>
    <form method="POST" action="">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" value="<?php echo isset($user['username']) ? htmlspecialchars($user['username']) : ''; ?>" required><br>
        
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" value="<?php echo isset($user['email']) ? htmlspecialchars($user['email']) : ''; ?>" required><br>
        
        <button type="submit">Mettre à jour</button>
    </form>

    <p><a href="index.php">Retour à la liste des utilisateurs</a></p>
</body>
</html>

