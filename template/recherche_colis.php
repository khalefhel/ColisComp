<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de recherche</title>
    <link rel="stylesheet" href="../css/recherche_colis.css">
<?php
// Connexion à la base de données
$connexion = new mysqli("localhost", "root", "", "coliscomp");

// Vérifier la connexion
if ($connexion->connect_error) {
    die("Erreur de connexion à la base de données : " . $connexion->connect_error);
}

// Vérifier si les champs de recherche sont présents dans l'URL
if (isset($_GET['point_depart']) && isset($_GET['destination'])) {
    // Nettoyer les champs de recherche pour éviter les injections SQL
    $point_depart = $connexion->real_escape_string($_GET['point_depart']);
    $destination = $connexion->real_escape_string($_GET['destination']);

    // Requête pour sélectionner les annonces correspondant à la recherche
    $sql = "SELECT * FROM annoncecolistransport WHERE PointDepart LIKE '%$point_depart%' AND Destination LIKE '%$destination%'";
    $resultat = $connexion->query($sql);
} else {
    // Si les champs de recherche ne sont pas présents, rediriger vers la page d'accueil ou une autre page appropriée
    header("Location: afficher_colis_transport.php"); // Remplacez "afficher_colis_transport.php" par le nom de votre page d'accueil si nécessaire
    exit();
}
?>
</head>
<?php include '../template/header.php'; ?>
<body>
<div class="container mt-5">
    <h1>Résultats de recherche</h1>
    <div class="row">
        <?php
        // Vérifier si des annonces correspondant à la recherche sont disponibles
        if ($resultat->num_rows > 0) {
            // Parcourir les annonces et les afficher dans des cartes Bootstrap
            while ($row = $resultat->fetch_assoc()) {
                ?>
                <div class="col-lg-8">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $row["PointDepart"]; ?> - <?php echo $row["Destination"]; ?></h5>
                            <p class="card-text"><?php echo $row["DescriptionColis"]; ?></p>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Date de départ: <?php echo $row["DateDepart"]; ?></li>
                                <li class="list-group-item">Date d'arrivée prévue: <?php echo $row["DateArriveePrevue"]; ?></li>
                                <li class="list-group-item">Poids: <?php echo $row["PoidsColis"]; ?> kg</li>
                                <!-- Ajoutez ici les autres champs -->
                                <li class="list-group-item">Hauteur: <?php echo $row["hauteur"]; ?></li>
                                <li class="list-group-item">Largeur: <?php echo $row["largeur"]; ?></li>
                                <li class="list-group-item">Longueur: <?php echo $row["longueur"]; ?></li>
                                <!-- Assurez-vous que les noms de colonnes correspondent aux clés dans $row -->
                                <li class="list-group-item">Prix proposé: <?php echo $row["PrixPropose"]; ?> €</li>
                                <li class="list-group-item">Statut: <?php echo $row["Statut"]; ?></li>
                                <!-- Bouton "Transporter" -->
                                <a href="../template/détails_réservation.php?id=<?php echo $row["ID"]; ?>" class="btn btn-primary mt-3">Envoyer mon colis avec ce livreur</a>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2"></div>
                <?php
            }
        } else {
            echo "<p>Aucun résultat trouvé pour votre recherche.</p>";
        }


        ?>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
</body>
</html>
