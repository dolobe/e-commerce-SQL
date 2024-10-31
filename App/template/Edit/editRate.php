<?php
include '../../Configuration/config.php';

if (isset($_GET['id'])) {
    $id_rate = $_GET['id'];
    $sql = "SELECT * FROM rate WHERE id_rate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_rate);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $rate = $result->fetch_assoc();
    } else {
        echo "Évaluation non trouvée.";
        exit;
    }
} else {
    echo "Aucun ID d'évaluation spécifié.";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_user = $_POST['id_user'];
    $id_product = $_POST['id_product'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    // Validation de la note
    if ($rating < 1 || $rating > 5) {
        echo "La note doit être comprise entre 1 et 5.";
        exit;
    }

    $sql = "UPDATE rate SET id_user = ?, id_product = ?, rating = ?, comment = ? WHERE id_rate = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisii", $id_user, $id_product, $rating, $comment, $id_rate);

    if ($stmt->execute()) {
        echo "Évaluation mise à jour avec succès!";
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
    <title>Modifier l'Évaluation</title>
</head>
<body>
    <h1>Modifier l'Évaluation</h1>
    <form method="POST" action="">
        <label for="id_user">ID Utilisateur :</label>
        <input type="number" id="id_user" name="id_user" value="<?php echo htmlspecialchars($rate['id_user']); ?>" required><br>

        <label for="id_product">ID Produit :</label>
        <input type="number" id="id_product" name="id_product" value="<?php echo htmlspecialchars($rate['id_product']); ?>" required><br>

        <label for="rating">Note :</label>
        <input type="number" id="rating" name="rating" min="1" max="5" value="<?php echo htmlspecialchars($rate['rating']); ?>" required><br>

        <label for="comment">Commentaire :</label>
        <textarea id="comment" name="comment" required><?php echo htmlspecialchars($rate['comment']); ?></textarea><br>
        
        <button type="submit">Mettre à jour</button>
    </form>

    <p><a href="rate.php">Retour à la liste des évaluations</a></p>
</body>
</html>
