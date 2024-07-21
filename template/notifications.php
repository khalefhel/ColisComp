<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>coliscomp - Notifications</title>
    <link rel="stylesheet" href="../css/notifications.css">
    <link rel="icon" href="icon.png">
<?php
include '../template/header.php';
// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur_id'])) {
    header("Location: login.php");
    exit();
}

// Connexion à la base de données
$connexion = new mysqli("localhost", "root", "", "coliscomp");

// Vérifiez la connexion
if ($connexion->connect_error) {
    die("Erreur de connexion à la base de données : " . $connexion->connect_error);
}

$user_id = $_SESSION['utilisateur_id'];

// Marquer toutes les notifications non lues comme lues pour l'utilisateur actuel
$sql_update = "UPDATE annoncebesointransport SET is_read = 1 WHERE UtilisateurID = ? AND is_read = 0";
$stmt_update = $connexion->prepare($sql_update);
$stmt_update->bind_param("i", $user_id);
$stmt_update->execute();
$stmt_update->close();

// Sélectionner les notifications non payées pour l'utilisateur actuel
$sql = "SELECT * FROM annoncebesointransport WHERE UtilisateurID = ? AND Statut = 'en attente de payement'";
$stmt = $connexion->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result_non_payees = $stmt->get_result();

// Sélectionner les notifications payées pour l'utilisateur actuel
$sql_paye = "SELECT t.*, a.PointDepartSouhaite, a.DestinationSouhaitee, a.DescriptionColis, a.PoidsColis, a.DateLimiteEnvoi, a.Budget, a.nombres_de_colis 
             FROM transaction t
             JOIN annoncebesointransport a ON t.annoncebesointransportID = a.ID
             WHERE t.UtilisateurID = ? AND t.annoncebesointransportID IS NOT NULL";
$stmt_paye = $connexion->prepare($sql_paye);
$stmt_paye->bind_param("i", $user_id);
$stmt_paye->execute();
$result_payees = $stmt_paye->get_result();
?>
</head>
<body>
    <div class="container">
        <h2>Notifications non payées</h2>
        <div class="row">
        <?php if ($result_non_payees->num_rows > 0) { ?>
            <?php while ($row = $result_non_payees->fetch_assoc()) { ?>
            <div class="notification">
                <div class="notification-body">
                    <h5 class="notification-title">Destination: <?php echo htmlspecialchars($row['DestinationSouhaitee']); ?></h5>
                    <p class="notification-text"><strong>Point de départ :</strong> <?php echo htmlspecialchars($row['PointDepartSouhaite']); ?></p>
                    <p class="notification-text"><strong>Description :</strong> <?php echo htmlspecialchars($row['DescriptionColis']); ?></p>
                    <p class="notification-text"><strong>Poids :</strong> <?php echo htmlspecialchars($row['PoidsColis']); ?> kg</p>
                    <p class="notification-text"><strong>Date limite :</strong> <?php echo htmlspecialchars($row['DateLimiteEnvoi']); ?></p>
                    <p class="notification-text"><strong>Budget :</strong> <?php echo htmlspecialchars($row['Budget']); ?> €</p>
                    <form method="POST" action="/coliscomp1/Controlleur/chekout_payement1.php">
                        <input type="hidden" name="annonce_id" value="<?php echo $row['ID']; ?>">
                        <input type="hidden" name="budget" value="<?php echo $row['Budget']; ?>">
                        <button class="button primary-button" type="submit">Payer</button>
                    </form>
                </div>
            </div>
            <?php } ?>
        <?php } else { ?>
            <p>Aucune notification non payée.</p>
        <?php } ?>
        </div>

        <h2>Notifications payées</h2>
        <div class="row">
        <?php if ($result_payees->num_rows > 0) { ?>
            <?php while ($row = $result_payees->fetch_assoc()) { ?>
            <div class="notification">
                <div class="notification-body">
                    <h5 class="notification-title">Destination: <?php echo htmlspecialchars($row['DestinationSouhaitee']); ?></h5>
                    <p class="notification-text"><strong>Point de départ :</strong> <?php echo htmlspecialchars($row['PointDepartSouhaite']); ?></p>
                    <p class="notification-text"><strong>Description :</strong> <?php echo htmlspecialchars($row['DescriptionColis']); ?></p>
                    <p class="notification-text"><strong>Poids :</strong> <?php echo htmlspecialchars($row['PoidsColis']); ?> kg</p>
                    <p class="notification-text"><strong>Date limite :</strong> <?php echo htmlspecialchars($row['DateLimiteEnvoi']); ?></p>
                    <p class="notification-text"><strong>Budget :</strong> <?php echo htmlspecialchars($row['Budget']); ?> €</p>
                </div>
            </div>
            <?php } ?>
        <?php } else { ?>
            <p>Aucune notification payée.</p>
        <?php } ?>
        </div>
    </div>
</body>
</html>

<?php
$stmt->close();
$stmt_paye->close();
$connexion->close();
?>
