<?php
include '../Configuration/config.php';

if (isset($_GET['delete_id'])) {
    $id_invoice = $_GET['delete_id'];
    $sql = "DELETE FROM invoice WHERE id_invoice = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_invoice);

    if ($stmt->execute()) {
        echo "Facture supprimée avec succès!";
        header("Location: invoice.php");
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
    <title>Gestion des Factures</title>
    <link rel="stylesheet" href="../CSS/table.css">
</head>
<body>
    <h1>Liste des Factures</h1>
    <p><a href="Add/addInvoice.php">Ajouter une Facture</a></p>

    <h2>Rechercher une Facture</h2>
    <form method="GET" action="invoice.php">
        <input type="text" name="search" placeholder="Rechercher par ID Facture, ID Commande ou Date" value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
        <button type="submit">Rechercher</button>
    </form>

    <table border="1">
        <tr>
            <th>ID Facture</th>
            <th>ID Commande</th>
            <th>Date de la Facture</th>
            <th>Prix Total</th>
            <th>Date de Création</th>
            <th>Action</th>
        </tr>
        <?php
        $search = isset($_GET['search']) ? "%" . $_GET['search'] . "%" : "%";
        $sql = "SELECT * FROM invoice 
                WHERE id_invoice LIKE ? 
                OR id_command LIKE ? 
                OR invoice_date LIKE ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $search, $search, $search);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id_invoice']}</td>
                        <td>{$row['id_command']}</td>
                        <td>{$row['invoice_date']}</td>
                        <td>{$row['total_price']}</td>
                        <td>{$row['created_at']}</td>
                        <td>
                            <a href='Edit/editInvoice.php?id={$row['id_invoice']}'>Modifier</a> 
                            |
                            <a href='?delete_id={$row['id_invoice']}' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cette facture ?\");'>Supprimer</a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Aucune facture trouvée</td></tr>";
        }
        ?>
    </table>
    <button onclick="window.history.back()">Retour</button>
</body>
</html>
