<?php
include '../../Configuration/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = $_POST['id_user'];
    $id_product = $_POST['id_product'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    if ($rating < 1 || $rating > 5) {
        echo "La note doit être comprise entre 1 et 5.";
        exit;
    }

    $sql = "INSERT INTO rate (id_user, id_product, rating, comment) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiis", $id_user, $id_product, $rating, $comment);

    if ($stmt->execute()) {
        echo "Évaluation ajoutée avec succès!";
        header("Location: rate.php");
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
    <title>Ajouter une Évaluation</title>
</head>
<body>
    <h1>Ajouter une Évaluation</h1>
    <form method="POST" action="">
        <label for="id_user">ID Utilisateur :</label>
        <input type="number" id="id_user" name="id_user" required><br>

        <label for="id_product">ID Produit :</label>
        <input type="number" id="id_product" name="id_product" required><br>

        <label for="rating">Note :</label>
        <input type="number" id="rating" name="rating" min="1" max="5" required><br>

        <label for="comment">Commentaire :</label>
        <textarea id="comment" name="comment" required></textarea><br>
        
        <button type="submit">Ajouter l'Évaluation</button>
    </form>

    <p><a href="rate.php">Retour à la liste des évaluations</a></p>
</body>
</html>
