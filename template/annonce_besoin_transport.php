
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une annonce de besoin de transport</title>
    <link rel="stylesheet" href="../css/annonce_besoin_transport.css">
<?php
include '../template/header.php';

// Vérifier si une session est déjà active avant de démarrer une nouvelle session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur_id'])) {
    echo '<div class="message-container">';
    echo "<p class='message'>Pour effectuer cette action, vous devez vous connecter.</p>";
    echo '<a class="message-link" href="/Controlleur/login.php">Se connecter</a>';
    echo '</div>';
    exit();
}

// Récupérer l'ID de l'utilisateur à partir de la session
$utilisateur_id = $_SESSION['utilisateur_id'];

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
    $description = $_POST["description"];
    $poids = $_POST["poids"];
    $date_limite_envoi = $_POST["date_limite_envoi"];
    $budget = $_POST["budget"];
    $statut = 'actif';

    // Préparer la requête d'insertion
    $sql = "INSERT INTO AnnonceBesoinTransport (UtilisateurID, PointDepartSouhaite, DestinationSouhaitee, DescriptionColis, PoidsColis, DateLimiteEnvoi, Budget, Statut) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = $connexion->prepare($sql)) {
        // Lier les paramètres
        $stmt->bind_param("isssdsss", $utilisateur_id, $point_depart, $destination, $description, $poids, $date_limite_envoi, $budget, $statut);

        // Exécuter la requête
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>L'annonce de besoin de transport a été ajoutée avec succès.</div>";
        } else {
            echo "<div class='alert alert-danger'>Erreur lors de l'insertion de l'annonce de besoin de transport : " . $stmt->error . "</div>";
        }

        // Fermer la requête
        $stmt->close();
    } else {
        echo "<div class='alert alert-danger'>Erreur de préparation de la requête : " . $connexion->error . "</div>";
    }
}

// Fermer la connexion
$connexion->close();
?>
</head>
<body>
    <div class="container mt-5">
        <h1>Ajouter une annonce de besoin de transport</h1>
        <div class="row">
            <div class="col-md-12">
                <form method="post" action="">
                    <div class="form-group">
                        <label for="point_depart">Point de départ souhaité</label>
                        <input type="text" class="form-control" id="point_depart" name="point_depart" placeholder="Point de départ souhaité" required>
                    </div>
                    <div class="form-group">
                        <label for="destination">Destination souhaitée</label>
                        <input type="text" class="form-control" id="destination" name="destination" placeholder="Destination souhaitée" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description du colis</label>
                        <textarea class="form-control" id="description" name="description" placeholder="Description du colis" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="poids">Poids du colis (kg)</label>
                        <input type="number" class="form-control" id="poids" name="poids" placeholder="Poids du colis (kg)" step="0.01" required>
                    </div>
                    <div class="form-group">
                        <label for="date_limite_envoi">Date limite d'envoi</label>
                        <input type="date" class="form-control" id="date_limite_envoi" name="date_limite_envoi" required>
                    </div>
                    <div class="form-group">
                        <label for="budget">Budget (€)</label>
                        <input type="number" class="form-control" id="budget" name="budget" placeholder="Budget (€)" step="0.01" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter l'annonce</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
</body>
</html>
