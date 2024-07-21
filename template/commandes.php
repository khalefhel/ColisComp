<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes commandes en cours</title>
    <link rel="stylesheet" href="../css/commandes.css">
</head>
<body>
<?php
include '../template/header.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur_id'])) {
    echo '<div class="message-container">';
    echo "<p class='message'>Pour effectuer cette action, vous devez vous connecter.</p>";
    echo '<a class="message-link" href="connexion.php">Se connecter</a>';
    echo '</div>';
    exit();
}

// ID de l'utilisateur connecté
$user_id = $_SESSION['utilisateur_id'];
$user_role = $_SESSION['utilisateur_Role'];

// Vérifier si l'utilisateur a le rôle de livreur
if ($user_role == 'livreur') {
    try {
        // Connexion à la base de données avec PDO
        $connexion = new PDO("mysql:host=localhost;dbname=ColisComp", "root", "");
        $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Préparer la requête SQL pour sélectionner les annonces de besoin de transport assignées au livreur actuel
        $sql_livreur = "SELECT abt.*, u.NumeroTelephone
                        FROM AnnonceBesoinTransport abt
                        JOIN Utilisateur u ON abt.UtilisateurID = u.ID
                        WHERE abt.livreur_id = :user_id";
        $stmt_livreur = $connexion->prepare($sql_livreur);
        $stmt_livreur->execute(['user_id' => $user_id]);
        $annonces_livreur = $stmt_livreur->fetchAll(PDO::FETCH_ASSOC);
?>
        <div class="container">
            <h1 class="text-center">Mes commandes en cours</h1>
            
            <!-- Annonces pour lesquelles l'utilisateur est le livreur -->
            <?php if ($annonces_livreur) { ?>
                <div class="annonces">
                    <?php foreach ($annonces_livreur as $annonce) { ?>
                        <div class="annonce">
                            <h3><?php echo htmlspecialchars($annonce['DestinationSouhaitee']); ?></h3>
                            <p><strong>Point de départ :</strong> <?php echo htmlspecialchars($annonce['PointDepartSouhaite']); ?></p>
                            <p><strong>Description :</strong> <?php echo htmlspecialchars($annonce['DescriptionColis']); ?></p>
                            <p><strong>Poids du colis :</strong> <?php echo htmlspecialchars($annonce['PoidsColis']); ?> kg</p>
                            <p><strong>Date limite d'envoi :</strong> <?php echo htmlspecialchars($annonce['DateLimiteEnvoi']); ?></p>
                            <p><strong>Budget :</strong> <?php echo htmlspecialchars($annonce['Budget']); ?> €</p>
                            <p><strong>Statut :</strong> <?php echo htmlspecialchars($annonce['Statut']); ?></p>
                            <?php if ($annonce['Statut'] == 'paye') { ?>
                                <p><strong>Numéro de téléphone :</strong> <?php echo htmlspecialchars($annonce['NumeroTelephone']); ?></p>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
                <a href="../template/afficher_besoin_transport.php" class="btn btn-primary">Voir les annonces</a>
            <?php } else { ?>
                <p>Vous n'avez pas de commandes en cours.</p>
            <?php } ?>
        </div>
<?php
    } catch (PDOException $e) {
        // En cas d'erreur de connexion ou d'exécution de requête
        echo "<div class='alert alert-danger'>Erreur : " . $e->getMessage() . "</div>";
    } finally {
        // Fermer la connexion
        $connexion = null;
    }
} else {
    echo '<div class="message-container">';
    echo "<p class='message'>Ooops! Pour consulter les annonces de besoin de transport, vous devez être connecté en tant que livreur.</p>";
    echo '<a href="../template/ajout_infos.php" class="message-link">Mettre à jour mon profil</a>';
    echo '</div>';
}
?>
</body>
</html>
