<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Commandes</title>
    <link rel="stylesheet" href="../css/mes_commandes_utilisateur.css">
<?php
include '../template/header.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur_id'])) {
    echo '<div class="message-container">';
    echo "<p class='message'>Pour effectuer cette action, vous devez vous connecter.</p>";
    echo '<a class="message-link" href="/Controlleur/login.php">Se connecter</a>';
    echo '</div>';
    exit();
}

// ID de l'utilisateur connecté
$user_id = $_SESSION['utilisateur_id'];

try {
    // Connexion à la base de données avec PDO
    $connexion = new PDO("mysql:host=localhost;dbname=coliscomp", "root", "");
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Préparer la requête SQL pour sélectionner les annonces de besoin de transport de l'utilisateur actuel
    $sql_utilisateur = "SELECT * FROM AnnonceBesoinTransport WHERE UtilisateurID = :user_id";
    $stmt_utilisateur = $connexion->prepare($sql_utilisateur);
    $stmt_utilisateur->execute(['user_id' => $user_id]);
    $annonces_utilisateur = $stmt_utilisateur->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // En cas d'erreur de connexion ou d'exécution de requête
    die("Erreur : " . $e->getMessage());
}
?>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Mes Commandes</h1>
        
        <!-- Commandes de l'utilisateur -->
        <?php if ($annonces_utilisateur) { ?>
            <div class="row">
                <?php foreach ($annonces_utilisateur as $annonce) { ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($annonce['DestinationSouhaitee']); ?></h5>
                                <p class="card-text"><strong>Point de départ :</strong> <?php echo htmlspecialchars($annonce['PointDepartSouhaite']); ?></p>
                                <p class="card-text"><strong>Description :</strong> <?php echo htmlspecialchars($annonce['DescriptionColis']); ?></p>
                                <p class="card-text"><strong>Poids du colis :</strong> <?php echo htmlspecialchars($annonce['PoidsColis']); ?> kg</p>
                                <p class="card-text"><strong>Date limite d'envoi :</strong> <?php echo htmlspecialchars($annonce['DateLimiteEnvoi']); ?></p>
                                <p class="card-text"><strong>Budget :</strong> <?php echo htmlspecialchars($annonce['Budget']); ?> €</p>
                                <p class="card-text"><strong>Statut :</strong> <?php echo htmlspecialchars($annonce['Statut']); ?></p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <p class="text-center">Vous n'avez pas de commandes.</p>
        <?php } ?>
    </div>
</body>
</html>
<?php
// Fermer la connexion
$connexion = null;
?>
