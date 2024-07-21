<?php
// Connexion à la base de données
$connexion = new mysqli("localhost", "root", "", "coliscomp");

// Vérifier la connexion
if ($connexion->connect_error) {
    die("Erreur de connexion à la base de données : " . $connexion->connect_error);
}

// Vérifier si les champs de recherche sont présents dans l'URL
if (isset($_GET['ville_depart']) && isset($_GET['ville_arrivee'])) {
    // Nettoyer les champs de recherche pour éviter les injections SQL
    $ville_depart = $connexion->real_escape_string($_GET['ville_depart']);
    $ville_arrivee = $connexion->real_escape_string($_GET['ville_arrivee']);

    // Requête pour sélectionner les annonces correspondant à la recherche
    $sql = "SELECT * FROM AnnonceBesoinTransport WHERE PointDepartSouhaite LIKE '%$ville_depart%' AND DestinationSouhaitee LIKE '%$ville_arrivee%'";
    $resultat = $connexion->query($sql);
} else {
    // Si les champs de recherche ne sont pas présents, rediriger vers la page d'accueil ou une autre page appropriée
    header("Location: afficher_besoin_transport.php"); // Remplacez "afficher_besoin_transport.php" par le nom de votre page d'accueil si nécessaire
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de recherche</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body class="body">
    <div class="container mt-5">
        <h1 class="mb-4">Résultats de recherche</h1>

        <div class="row">
            <?php
            // Vérifier si des annonces correspondant à la recherche sont disponibles
            if ($resultat && $resultat->num_rows > 0) {
                // Parcourir les annonces et les afficher dans des cartes Bootstrap
                while ($row = $resultat->fetch_assoc()) {
            ?>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['DestinationSouhaitee']; ?></h5>
                                <p class="card-text"><strong>Point de départ :</strong> <?php echo $row['PointDepartSouhaite']; ?></p>
                                <p class="card-text"><strong>Description :</strong> <?php echo $row['DescriptionColis']; ?></p>
                                <p class="card-text"><strong>Poids du colis :</strong> <?php echo $row['PoidsColis']; ?> kg</p>
                                <p class="card-text"><strong>Date limite d'envoi :</strong> <?php echo $row['DateLimiteEnvoi']; ?></p>
                                <p class="card-text"><strong>Budget :</strong> <?php echo $row['Budget']; ?> €</p>
                                <p class="card-text"><strong>Statut :</strong> <?php echo $row['Statut']; ?></p>
                                <!-- Bouton "Transporter" -->
                                <a href="#" class="btn btn-primary">Transporter</a>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<p>Aucun résultat trouvé pour votre recherche.</p>";
            }
            ?>
        </div>
    </div>
</body>

</html>

<?php
// Fermer la connexion
$connexion->close();
?>
