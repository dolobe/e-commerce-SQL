<?php
include '../../Configuration/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO Users (username, email, password) VALUES ('$username', '$email', '$password')";
    
    if ($conn->query($sql) === TRUE) {
        echo "Nouvel utilisateur créé avec succès!";
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S'inscrire</title>
</head>
<body>
    <h1>S'inscrire</h1>
    <form method="POST" action="">
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" id="username" name="username" required><br>
        
        <label for="email">Email :</label>
        <input type="email" id="email" name="email" required><br>
        
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required><br>
        
        <button type="submit">S'inscrire</button>
    </form>

    <button onclick="window.history.back()">Retour</button>
</body>
</html>
