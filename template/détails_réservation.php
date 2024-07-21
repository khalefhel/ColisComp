<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails de l'Annonce</title>
    <link rel="stylesheet" href="../css/détails_réservation.css">
</head>
<?php include '../template/header.php';?>
<body>
<div class="container mt-5">
    <?php
    // Démarrer la session
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Vérifier si l'utilisateur est connecté en vérifiant s'il y a une session d'utilisateur active
    if(isset($_SESSION['utilisateur_id'])) {
        // Récupérer l'ID de l'utilisateur depuis la session
        $utilisateur_id = $_SESSION['utilisateur_id'];
        
        // Connexion à la base de données
        $connexion = new mysqli("localhost", "root", "", "coliscomp");

        // Vérifier la connexion
        if ($connexion->connect_error) {
            die("Erreur de connexion à la base de données : " . $connexion->connect_error);
        }

        // Vérifie si l'ID de l'annonce est passé dans l'URL
        if(isset($_GET['id'])) {
            // Récupère l'ID de l'annonce depuis l'URL
            $annonce_id = $_GET['id'];

            // Requête préparée pour récupérer les détails de l'annonce en fonction de son ID
            $sql = "SELECT * FROM annoncecolistransport WHERE ID = ?";
            
            // Préparation de la requête
            $requete = $connexion->prepare($sql);
            
            // Liaison des paramètres
            $requete->bind_param("i", $annonce_id);
            
            // Exécution de la requête
            $requete->execute();
            
            // Récupération des résultats
            $resultat = $requete->get_result();

            // Vérifier si une annonce correspondant à l'ID a été trouvée
            if ($resultat->num_rows > 0) {
                // Récupérer les détails de l'annonce
                $row = $resultat->fetch_assoc();
                ?>
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row["PointDepart"]; ?> - <?php echo $row["Destination"]; ?></h5>
                        <p class="card-text"><?php echo $row["DescriptionColis"]; ?></p>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Date de départ: <?php echo $row["DateDepart"]; ?></li>
                            <li class="list-group-item">Date d'arrivée prévue: <?php echo $row["DateArriveePrevue"]; ?></li>
                            <li class="list-group-item">Poids: <?php echo $row["PoidsColis"]; ?> kg</li>
                            <li class="list-group-item">Hauteur: <?php echo $row["hauteur"]; ?></li>
                            <li class="list-group-item">Largeur: <?php echo $row["largeur"]; ?></li>
                            <li class="list-group-item">Longueur: <?php echo $row["longueur"]; ?></li>
                            <li class="list-group-item">Prix proposé: <?php echo $row["PrixPropose"]; ?> €</li>
                            <li class="list-group-item">Statut: <?php echo $row["Statut"]; ?></li>
                        </ul>
                        <!-- Bouton de paiement -->
                        <form action="/coliscomp1/Controlleur/chekout_payement.php" method="POST">
                            <input type="hidden" name="annonce_id" value="<?php echo $annonce_id; ?>">
                            <input type="hidden" name="prix_propose" value="<?php echo $row['PrixPropose']; ?>">
                            <button type="submit" class="btn btn-primary">Payer</button>
                        </form>
                    </div>
                </div>
                <?php
            } else {
                echo "<p>Aucune annonce trouvée avec cet ID.</p>";
            }

            // Fermer la connexion
            $connexion->close();
        } else {
            echo "<p>Paramètre ID manquant dans l'URL.</p>";
        }

    } else {
        // Si l'utilisateur n'est pas connecté, vous pouvez rediriger vers une page de connexion ou afficher un message d'erreur
        echo "Vous devez être connecté pour voir cette page.";
    }
    ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
</body>
</html>
