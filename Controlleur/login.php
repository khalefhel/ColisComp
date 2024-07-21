<?php
// Vérifier si le formulaire d'inscription a été soumis
if (isset($_POST["inscription"])) {
    // Récupérer les données soumises
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $email = $_POST["email"];
    $motDePasse = $_POST["motDePasse"]; // Mot de passe non haché ici
    $numeroTelephone = $_POST["numeroTelephone"];
    $adresse = $_POST["adresse"];

    // Hacher le mot de passe
    $motDePasseHash = password_hash($motDePasse, PASSWORD_DEFAULT);

    // Connexion à la base de données (vous devez inclure votre fichier de configuration de base de données ici)
    $connexion = new mysqli("localhost", "root", "", "coliscomp");

    // Vérifier la connexion
    if ($connexion->connect_error) {
        die("Erreur de connexion à la base de données : " . $connexion->connect_error);
    }

    // Préparer la requête SQL d'insertion
    $requete = $connexion->prepare("INSERT INTO Utilisateur (Nom, Prenom, Email, MotDePasse, NumeroTelephone, Adresse) VALUES (?, ?, ?, ?, ?, ?)");
    $requete->bind_param("ssssss", $nom, $prenom, $email, $motDePasseHash, $numeroTelephone, $adresse);

    // Exécuter la requête
    if ($requete->execute()) {
        echo "Inscription réussie !";
    } else {
        echo "Erreur lors de l'inscription : " . $requete->error;
    }

    // Fermer la connexion
    $requete->close();
    $connexion->close();
}

// Vérifier si le formulaire de connexion a été soumis
if (isset($_POST["connexion"])) {
    // Récupérer les données soumises
    $email_connexion = $_POST["email_connexion"];
    $motDePasse_connexion = $_POST["motDePasse_connexion"];

    // Connexion à la base de données (vous devez inclure votre fichier de configuration de base de données ici)
    $connexion = new mysqli("localhost", "root", "", "coliscomp");

    // Vérifier la connexion
    if ($connexion->connect_error) {
        die("Erreur de connexion à la base de données : " . $connexion->connect_error);
    }

    // Préparer la requête SQL pour vérifier l'utilisateur
    $requete = $connexion->prepare("SELECT * FROM Utilisateur WHERE Email = ?");
    $requete->bind_param("s", $email_connexion);

    // Exécuter la requête
    $requete->execute();

    // Récupérer le résultat de la requête
    $resultat = $requete->get_result();

    // Vérifier si l'utilisateur existe et si le mot de passe est correct
    if ($resultat->num_rows == 1) {
        $utilisateur = $resultat->fetch_assoc();
        if (password_verify($motDePasse_connexion, $utilisateur["MotDePasse"])) {
            // L'utilisateur est connecté avec succès
            session_start();
            $_SESSION["utilisateur_id"] = $utilisateur["ID"];
            $_SESSION['utilisateur_Role'] = $utilisateur["Role"]; // Stockez le rôle de l'utilisateur dans la session           
            $_SESSION['utilisateur_Email'] = $utilisateur["Email"];
            $_SESSION["NumeroTelephone"] = $utilisateur["NumeroTelephone"];
            $_SESSION["Prenom"] = $utilisateur["Prenom"];
            
            echo "Connexion réussie !";
            // Redirection vers la page de tableau de bord ou autre page après la connexion
            header("Location: ../index.php");
            exit();
        } else {
            echo "Mot de passe incorrect";
        }
    } else {
        echo "Utilisateur non trouvé";
    }

    // Fermer la connexion 
    $requete->close();
    $connexion->close();
}
?>
