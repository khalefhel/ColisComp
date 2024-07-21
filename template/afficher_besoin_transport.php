<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annonces de besoin de transport</title>
    <link rel="stylesheet" href="../css/afficher_besoin_transport.css">
</head>
<body>
<?php
include '../template/header.php';

// Démarrer la session si ce n'est pas déjà fait
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

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

// Connexion à la base de données avec MySQLi
$connexion = new mysqli("localhost", "root", "", "coliscomp");

// Vérifier la connexion
if ($connexion->connect_error) {
    die("Erreur de connexion à la base de données : " . $connexion->connect_error);
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['annonce_id'])) {
    $annonce_id = intval($_POST['annonce_id']);
    $livreur_id = $user_id; // ID de l'utilisateur connecté

    // Mettre à jour l'annonce avec le livreur_id
    $sql = "UPDATE AnnonceBesoinTransport SET livreur_id = ?, Statut = 'en attente de payement' WHERE ID = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("ii", $livreur_id, $annonce_id);

    if ($stmt->execute()) {
        // Insérer les données dans la table transaction
        $sql_insert = "INSERT INTO transaction (AnnonceColisTransportID, AnnonceBesoinTransportID, UtilisateurID, PrixConvenu, livreur_id) VALUES (?, ?, ?, ?, ?)";
        $stmt_insert = $connexion->prepare($sql_insert);

        // Ici, AnnonceColisTransportID est mis à null
        $annonce_colis_transport = null;

        // Récupérer les informations de l'utilisateur et du prix proposé
        $sql_select = "SELECT UtilisateurID, PrixPropose FROM annoncecolistransport WHERE ID = ?";
        $stmt_select = $connexion->prepare($sql_select);
        $stmt_select->bind_param("i", $annonce_id);
        $stmt_select->execute();
        $result = $stmt_select->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $utilisateur_id = $row['UtilisateurID'];
            $prix_convenu = $row['PrixPropose'];

            $stmt_insert->bind_param("iiidi", $annonce_colis_transport, $annonce_id, $utilisateur_id, $prix_convenu, $livreur_id);
            if ($stmt_insert->execute()) {
                echo '
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        Le paiement a été enregistré avec succès. Vous serez prochainement contacté par le livreur à votre numéro pour préciser un point de récupération de colis.
    </div>';

            } else {
                echo "Erreur lors de l'insertion des données dans la table transaction : " . $stmt_insert->error;
            }
        } else {
            echo "Aucune annonce trouvée avec cet ID.";
        }

        $stmt_select->close();
        $stmt_insert->close();
    } else {
        echo "Erreur lors de la mise à jour de l'annonce : " . $stmt->error;
    }

    $stmt->close();
}

// Fermer la connexion MySQLi
$connexion->close();

// Vérifier si l'utilisateur a le rôle de livreur
if ($user_role == 'livreur') {
    try {
        // Connexion à la base de données avec PDO
        $connexion = new PDO("mysql:host=localhost;dbname=coliscomp", "root", "");

        // Préparer la requête SQL pour sélectionner les annonces de besoin de transport non assignées à l'utilisateur actuel
        $sql_autres = "SELECT * FROM AnnonceBesoinTransport WHERE UtilisateurID != :user_id AND DateLimiteEnvoi >= NOW() AND Statut = 'actif'";
        $stmt_autres = $connexion->prepare($sql_autres);
        $stmt_autres->execute(['user_id' => $user_id]);
        $annonces_autres = $stmt_autres->fetchAll(PDO::FETCH_ASSOC);

?>
            <div class="container">
                <h1>Afficher les annonces des expéditeurs</h1>

                <!-- Autres annonces -->
                <?php if ($annonces_autres) { ?>
                    <div class="annonces">
                        <?php foreach ($annonces_autres as $annonce) { ?>
                            <div class="annonce">
                                <h3><?php echo htmlspecialchars($annonce['DestinationSouhaitee']); ?></h3>
                                <p><strong>Point de départ :</strong> <?php echo htmlspecialchars($annonce['PointDepartSouhaite']); ?></p>
                                <p><strong>Description :</strong> <?php echo htmlspecialchars($annonce['DescriptionColis']); ?></p>
                                <p><strong>Poids du colis :</strong> <?php echo htmlspecialchars($annonce['PoidsColis']); ?> kg</p>
                                <p><strong>Date limite d'envoi :</strong> <?php echo htmlspecialchars($annonce['DateLimiteEnvoi']); ?></p>
                                <p><strong>Budget :</strong> <?php echo htmlspecialchars($annonce['Budget']); ?> €</p>
                                <!-- Bouton "Transporter" -->
                                <form method="POST" action="">
                                    <input type="hidden" name="annonce_id" value="<?php echo $annonce['ID']; ?>">
                                    <button type="submit">Transporter</button>
                                </form>
                            </div>
                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <p>Aucune annonce de besoin de transport disponible.</p>
                <?php } ?>
            </div>
<?php
    } catch (PDOException $e) {
        // En cas d'erreur de connexion ou d'exécution de requête
        echo "<div class='alert alert-danger'>Erreur : " . $e->getMessage() . "</div>";
    } finally {
        // Fermer la connexion PDO
        $connexion = null;
    }
} else {
    echo '<div class="message-container">';
    echo "<p class='message'>Oops! Pour consulter les annonces de transport, veuillez vous connecter en tant que livreur.</p>";
    echo '<a href="../template/ajout_infos.php" class="message-link">Mettre à jour mon profil</a>';
    echo '</div>';
}
?>
</body>
</html>
