
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Ajouter une annonce de transport de colis</title>
        <link rel="stylesheet" href="../css/annoncecolistrans.css">
        <link rel="icon" href="../images/icon.png">
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

// Récupérer l'ID de l'utilisateur à partir de la session
$utilisateur_id = $_SESSION['utilisateur_id'];
$role = $_SESSION['utilisateur_Role'];

// Connexion à la base de données
$connexion = new mysqli("localhost", "root", "", "coliscomp");

// Vérifier la connexion
if ($connexion->connect_error) {
    die("<div class='alert alert-danger'>Erreur de connexion à la base de données : " . $connexion->connect_error . "</div>");
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $point_depart = $_POST["point_depart"];
    $destination = $_POST["destination"];
    $description_colis = $_POST["description"];
    $poids_colis = $_POST["poids"];
    $date_depart = $_POST["date_depart"];
    $date_arrivee_prevue = $_POST["date_arrivee_prevue"];
    $prix_propose = $_POST["prix_propose"];
    $statut = $_POST["statut"];
    $hauteur = $_POST["hauteur"];
    $largeur = $_POST["largeur"];
    $longueur = $_POST["longueur"];

    // Préparer la requête d'insertion
    $sql = "INSERT INTO annoncecolistransport (UtilisateurID, PointDepart, Destination, DescriptionColis, PoidsColis, DateDepart, DateArriveePrevue, PrixPropose, Statut, hauteur, largeur, longueur) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $connexion->prepare($sql)) {
        // Lier les paramètres
        $stmt->bind_param("ssssssssssss", $utilisateur_id, $point_depart, $destination, $description_colis, $poids_colis, $date_depart, $date_arrivee_prevue, $prix_propose, $statut, $hauteur, $largeur, $longueur);

        // Exécuter la requête
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>L'annonce de colis a été ajoutée avec succès.</div>";
        } else {
            echo "<div class='alert alert-danger'>Erreur lors de l'insertion de l'annonce de colis : " . $stmt->error . "</div>";
        }

        // Fermer la requête
        $stmt->close();
    } else {
        echo "<div class='alert alert-danger'>Erreur de préparation de la requête : " . $connexion->error . "</div>";
    }

    // Fermer la connexion
    $connexion->close();
}

// Vérifier si l'utilisateur a le rôle de livreur
if ($role == 'livreur') {
    ?>
    </head>

    <body>
        <div class="container">
            <h1>Je transporte un colis sur mon trajet</h1>
            <form method="post" action="">
                <!-- Champ Point de départ -->
                <div class="form-group">
                    <label for="point_depart">Point de départ</label>
                    <input type="text" name="point_depart" id="point_depart" placeholder="Point de départ" required>
                </div>

                <!-- Champ Destination -->
                <div class="form-group">
                    <label for="destination">Destination</label>
                    <input type="text" name="destination" id="destination" placeholder="Destination" required>
                </div>

                <!-- Champ Description du colis -->
                <div class="form-group">
                    <label for="description">Description du colis</label>
                    <textarea name="description" id="description" placeholder="Description du colis" required></textarea>
                </div>

                <!-- Champ Poids du colis -->
                <div class="form-group">
                    <label for="poids">Poids du colis (kg)</label>
                    <input type="number" name="poids" id="poids" placeholder="Poids du colis (kg)" step="0.01" required>
                </div>

                <!-- Champ Date de départ -->
                <div class="form-group">
                    <label for="date_depart">Date de départ</label>
                    <input type="date" name="date_depart" id="date_depart" required>
                </div>

                <!-- Champ Date d'arrivée prévue -->
                <div class="form-group">
                    <label for="date_arrivee_prevue">Date d'arrivée prévue</label>
                    <input type="date" name="date_arrivee_prevue" id="date_arrivee_prevue" required>
                </div>

                <!-- Champ Hauteur maximale du colis -->
                <div class="form-group">
                    <label for="hauteur">Hauteur maximum des colis (cm)</label>
                    <input type="number" name="hauteur" id="hauteur" placeholder="Hauteur maximale du colis (cm)" step="1"
                        required>
                </div>

                <!-- Champ Largeur maximale du colis -->
                <div class="form-group">
                    <label for="largeur">Largeur maximale du colis (cm)</label>
                    <input type="number" name="largeur" id="largeur" placeholder="Largeur maximale du colis (cm)" step="1"
                        required>
                </div>

                <!-- Champ Longueur maximale du colis -->
                <div class="form-group">
                    <label for="longueur">Longueur maximale du colis (cm)</label>
                    <input type="number" name="longueur" id="longueur" placeholder="Longueur maximale du colis (cm)"
                        step="1" required>
                </div>

                <!-- Champ Prix proposé -->
                <div class="form-group">
                    <label for="prix_propose">Prix proposé (€)</label>
                    <input type="number" name="prix_propose" id="prix_propose" placeholder="Prix proposé (€)" step="0.01"
                        required>
                </div>

                <!-- Champ Statut -->
                <div class="form-group">
                    <label for="statut">Statut</label>
                    <select name="statut" id="statut" required>
                        <option value="actif">Actif</option>
                        <option value="annule">Annulé</option>
                        <option value="termine">Terminé</option>
                    </select>
                </div>

                <!-- Bouton de soumission -->
                <button type="submit">Ajouter l'annonce</button>
            </form>
        </div>
    </body>

    </html>

    <?php
} else {
    // Afficher un message invitant l'utilisateur à ajouter ses informations personnelles pour devenir livreur
    echo '<div class="message-container">';
    echo '<p class="message">Oops! Pour ajouter une annonce de livraison, veuillez d\'abord compléter vos informations personnelles afin de créer un compte livreur.</p>';
    // Ajouter un lien vers la page d'ajout d'informations
    echo '<a class="message-link" href="ajout_infos.php">Ajouter mes informations</a>';
    echo '</div>';
}
?>