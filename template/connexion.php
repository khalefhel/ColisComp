<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>coliscomp</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" type="image/x-icon" href="/images/icon.png">
</head>

<body>
    <?php include 'header.php'; ?>
    <?php
    // Initialize error message variable
    $errorMessage = '';

    // Vérifier si le formulaire d'inscription a été soumis
    if (isset($_POST["inscription"])) {
        // Récupérer les données soumises
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $email = $_POST["email"];
        $motDePasse = $_POST["motDePasse"];
        $numeroTelephone = $_POST["numeroTelephone"];
        $adresse = $_POST["adresse"];

        // Hacher le mot de passe
        $motDePasseHash = password_hash($motDePasse, PASSWORD_DEFAULT);

        // Connexion à la base de données
        $connexion = new mysqli("localhost", "root", "", "coliscomp");

        // Vérifier la connexion
        if ($connexion->connect_error) {
            die("<script>alert('Erreur de connexion à la base de données : " . $connexion->connect_error . "');</script>");
        }

        // Vérifier si l'adresse e-mail existe déjà
        $requete_verif = $connexion->prepare("SELECT * FROM Utilisateur WHERE Email = ?");
        $requete_verif->bind_param("s", $email);
        $requete_verif->execute();
        $resultat_verif = $requete_verif->get_result();

        if ($resultat_verif->num_rows > 0) {
            $errorMessage = 'Cet e-mail est déjà utilisé. Veuillez en choisir un autre.';
        } else {
            // Préparer la requête SQL d'insertion
            $requete = $connexion->prepare("INSERT INTO Utilisateur (Nom, Prenom, Email, MotDePasse, NumeroTelephone, Adresse) VALUES (?, ?, ?, ?, ?, ?)");
            $requete->bind_param("ssssss", $nom, $prenom, $email, $motDePasseHash, $numeroTelephone, $adresse);

            // Exécuter la requête
            if ($requete->execute()) {
                // Rediriger vers la page de connexion après l'inscription réussie
                header('Location: connexion.php');
                exit();
            } else {
                $errorMessage = 'Erreur lors de l\'inscription : ' . $requete->error;
            }

            // Fermer la connexion
            $requete->close();
        }

        $requete_verif->close();
        $connexion->close();
    }

    // Vérifier si le formulaire de connexion a été soumis
    if (isset($_POST["connexion"])) {
        // Récupérer les données soumises
        $email_connexion = $_POST["email_connexion"];
        $motDePasse_connexion = $_POST["motDePasse_connexion"];

        // Connexion à la base de données
        $connexion = new mysqli("localhost", "root", "", "coliscomp");

        // Vérifier la connexion
        if ($connexion->connect_error) {
            die("<script>alert('Erreur de connexion à la base de données : " . $connexion->connect_error . "');</script>");
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
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION["utilisateur_id"] = $utilisateur["ID"];
                $_SESSION['utilisateur_Role'] = $utilisateur["Role"];
                $_SESSION['utilisateur_Email'] = $utilisateur["Email"];
                $_SESSION["NumeroTelephone"] = $utilisateur["NumeroTelephone"];
                $_SESSION["Prenom"] = $utilisateur["Prenom"];

                // Rediriger l'utilisateur sans afficher de message
                header('Location: ../index.php');
                exit();
            } else {
                $errorMessage = 'Mot de passe incorrect';
            }
        } else {
            $errorMessage = 'Utilisateur non trouvé';
        }

        // Fermer la connexion
        $requete->close();
        $connexion->close();
    }
    ?>
    <div class="content-wrapper">
        <div class="container" id="container">
            <div class="form-container sign-in">
                <form method="post" action="">
                    <h1>Connexion</h1>
                    <?php if ($errorMessage) : ?>
                        <div class="error-message"><?php echo $errorMessage; ?></div>
                    <?php endif; ?>
                    <input type="email" name="email_connexion" placeholder="Adresse email" required>
                    <input type="password" name="motDePasse_connexion" placeholder="Mot de passe" required>
                    <a href="#">Mot de passe oublié?</a>
                    <button type="submit" name="connexion">Suivant</button>
                    <span>- ou -</span>
                    <div class="social-icons">
                        <a href="#" class="icon"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="icon"><i class="fa-brands fa-google"></i></a>
                        <a href="#" class="icon"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="icon"><i class="fa-brands fa-x-twitter"></i></a>
                    </div>
                </form>
            </div>
            <div class="form-container sign-up">
                <form method="post" action="">
                    <h1>Inscription</h1>
                    <?php if ($errorMessage) : ?>
                        <div class="error-message"><?php echo $errorMessage; ?></div>
                    <?php endif; ?>
                    <input type="text" name="nom" placeholder="Nom" required>
                    <input type="text" name="prenom" placeholder="Prénom" required>
                    <input type="email" name="email" placeholder="Adresse email" required>
                    <input type="password" name="motDePasse" placeholder="Mot de passe" required>
                    <input type="password" name="confirmMotDePasse" placeholder="Confirmer le mot de passe" required>
                    <input type="tel" name="numeroTelephone" placeholder="Numéro de téléphone" required>
                    <input type="adresse" name="adresse" placeholder="Adresse" required>
                    <button type="submit" name="inscription">Suivant</button>
                </form>
            </div>
            <div class="toggle-container">
                <div class="toggle">
                    <div class="toggle-panel toggle-right">
                        <h1>Commencez votre trajet maintenant !</h1>
                        <p>Rejoignez notre communauté en cliquant ici pour créer votre compte</p>
                        <button class="hidden" id="register">Inscription</button>
                    </div>
                    <div class="toggle-panel toggle-left">
                        <h1>Continuez vos trajets d'où vous avez laissé.</h1>
                        <p>Déjà membre de notre communauté, cliquez ici pour vous connecter</p>
                        <button class="hidden" id="login">Connexion</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 coliscomp. Tous droits réservés.</p>
    </footer>

    <script src="../JS/script.js"></script>
</body>

</html>
