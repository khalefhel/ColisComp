<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté en vérifiant s'il y a une session d'utilisateur active
if(isset($_SESSION['utilisateur_id'])) {
    // Vérifier si l'ID de l'annonce est présent dans l'URL
    if(isset($_GET['annonce_id'])) {
        // Récupérer l'ID de l'annonce à partir de l'URL
        $annonce_id = $_GET['annonce_id'];
        $user_id = $_SESSION['utilisateur_id'];
        
        // Connexion à la base de données
        $connexion = new mysqli("localhost", "root", "", "coliscomp");

        // Vérifier la connexion
        if ($connexion->connect_error) {
            die("Erreur de connexion à la base de données : " . $connexion->connect_error);
        }

        // Requête SQL pour récupérer toutes les données de l'annonce en fonction de l'ID
        $sql = "SELECT UtilisateurID, Budget FROM annoncebesointransport WHERE ID = ?";
        
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
            // Récupérer les données de l'annonce
            $row = $resultat->fetch_assoc();
            $utilisateur_id = $row['UtilisateurID'];
            $prix_convenu = $row['Budget'];

            // Insérer les données dans la table transaction
            $sql_insert = "INSERT INTO transaction (AnnonceColisTransportID, AnnonceBesoinTransportID, UtilisateurID, PrixConvenu, livreur_id) VALUES (?, ?, ?, ?, ?)";
            $requete_insert = $connexion->prepare($sql_insert);
            $annonce_colis_transport_id = null;
            $livreur_id = $utilisateur_id; // Utiliser l'ID de l'utilisateur comme ID du livreur
            $requete_insert->bind_param("iiidi", $annonce_colis_transport_id,$annonce_id, $user_id, $prix_convenu, $livreur_id);
            if ($requete_insert->execute()) {
                // Mettre à jour le statut de l'annonce dans la table annoncecolistransport
                $sql_update = "UPDATE annoncebesointransport SET Statut = 'paye' WHERE ID = ?";
                $requete_update = $connexion->prepare($sql_update);
                $requete_update->bind_param("i", $annonce_id);
                if ($requete_update->execute()) {
                    echo '
                    <div class="message-container">
        <p class="message">
            Le paiement a été enregistré avec succès. Vous serez prochainement contacté par le livreur à votre numéro pour préciser un point de récupération de colis.
        </p>
        <a href="../index.php" class="btn">Retour à laccueil</a>
    </div>';
                } else {
                    echo "Erreur lors de la mise à jour du statut de l'annonce : " . $requete_update->error;
                }
            } else {
                echo "Erreur lors de l'insertion des données dans la table transaction : " . $requete_insert->error;
            }
        } else {
            echo "Aucune annonce trouvée avec cet ID.";
        }

        // Fermer la connexion
        $connexion->close();
    } else {
        echo "Paramètre d'ID de l'annonce manquant dans l'URL.";
    }
} else {
    echo "Vous devez être connecté pour effectuer cette action.";
}
?>
