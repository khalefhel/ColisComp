<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annonces de Colis à Transporter</title>
    <link rel="stylesheet" href="../css/afficher.css">
</head>
<?php include '../template/header.php'; ?>
<body>
    <div class="container">
        <h1 class="h1style">J'envoie mon colis</h1>
        <form class="search-form" method="GET" action="recherche_colis.php">
            <input class="search-input" type="search" placeholder="Point de départ" aria-label="Point de départ" name="point_depart">
            <input class="search-input" type="search" placeholder="Destination" aria-label="Destination" name="destination">
            <button class="btn-search" type="submit">Rechercher</button>
        </form>
        <div class="annonces">
            <?php
            // Connexion à la base de données
            $connexion = new mysqli("localhost", "root", "", "coliscomp");

            // Vérifier la connexion
            if ($connexion->connect_error) {
                die("Erreur de connexion à la base de données : " . $connexion->connect_error);
            }

            // Requête pour sélectionner les annonces de colis à transporter
            $sql = "SELECT * FROM annoncecolistransport WHERE Statut = 'actif'";
            $resultat = $connexion->query($sql);

            // Vérifier si des annonces ont été trouvées
            if ($resultat->num_rows > 0) {
                // Parcourir les résultats de la requête
                while ($row = $resultat->fetch_assoc()) {
                    ?>
                    <div class="annonce">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($row["PointDepart"]); ?> - <?php echo htmlspecialchars($row["Destination"]); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($row["DescriptionColis"]); ?></p>
                                <ul class="details-list">
                                    <li>Date de départ: <?php echo htmlspecialchars($row["DateDepart"]); ?></li>
                                    <li>Date d'arrivée prévue: <?php echo htmlspecialchars($row["DateArriveePrevue"]); ?></li>
                                    <li>Poids: <?php echo htmlspecialchars($row["PoidsColis"]); ?> kg</li>
                                    <li>Hauteur: <?php echo htmlspecialchars($row["hauteur"]); ?></li>
                                    <li>Largeur: <?php echo htmlspecialchars($row["largeur"]); ?></li>
                                    <li>Longueur: <?php echo htmlspecialchars($row["longueur"]); ?></li>
                                    <li>Prix proposé: <?php echo htmlspecialchars($row["PrixPropose"]); ?> €</li>
                                    <li>Statut: <?php echo htmlspecialchars($row["Statut"]); ?></li>
                                </ul>
                                <?php if ($row["Statut"] != 'en attente de payement') { ?>
                                    <a href="détails_réservation.php?id=<?php echo $row["ID"]; ?>" class="btn-primary">Envoyer mon colis avec ce livreur</a>
                                <?php } else { ?>
                                    <button class="btn-secondary" disabled>En attente de payement</button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>Aucune annonce de colis à transporter trouvée.</p>";
            }

            // Fermer la connexion
            $connexion->close();
            ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
</body>
</html>
