<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="../css/menu.css">
    <style>
        .notification-count {
            background-color: black;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
            margin-left: 5px;
        }
    </style>
</head>
<body>
    <?php
    session_start();
    if (isset($_SESSION['utilisateur_id'])) {
        $est_connecte = true;
        $Prenom = $_SESSION['Prenom'];
        $utilisateur_id = $_SESSION['utilisateur_id'];

        $connexion = new mysqli("localhost", "root", "", "coliscomp");

        if ($connexion->connect_error) {
            die("Erreur de connexion à la base de données : " . $connexion->connect_error);
        }

        $sql = "SELECT COUNT(*) as count FROM AnnonceBesoinTransport WHERE UtilisateurID = ? AND Statut = 'en attente de payement' AND is_read = 0";
        $stmt = $connexion->prepare($sql);
        $stmt->bind_param("i", $utilisateur_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $notifications_count = $row['count'];

        $stmt->close();
        $connexion->close();
    } else {
        $est_connecte = false;
        $notifications_count = 0;
    }
    ?>

    <div class="menu-bar">
        <a href="/coliscomp1/index.php"><h1 class="logo">Colis<span>Comp</span></h1></a>
        <ul>
            <li><a href="#">Transporteur <i class="fas fa-caret-down"></i></a>
                <div class="dropdown-menu">
                    <ul>
                        <li><a href="/coliscomp1/template/annoncecolistrans.php">Proposer un trajet</a></li>
                        <li><a href="/coliscomp1/template/afficher_besoin_transport.php">Transporter un colis</a></li>
                        <li><a href="/coliscomp1/template/commandes.php">Mes commandes</a></li>
                    </ul>
                </div>
            </li>
            <li><a href="#">Expéditeur <i class="fas fa-caret-down"></i></a>
                <div class="dropdown-menu">
                    <ul>
                        <li><a href="/coliscomp1/template/annonce_besoin_transport.php">Envoyer un colis</a></li>
                        <li><a href="/coliscomp1/template/mes_commandes_utilisateur.php">Mes commandes</a></li>
                        <li><a href="/coliscomp1/JS/conditions.html">Voir les conditions</a></li>
                    </ul>
                </div>
            </li>
            <li><a href="/coliscomp1/template/afficher_colis_transport.php">Voir les annonces</a></li>
            <li><a href="#">Mon compte <i class="fas fa-caret-down"></i></a>
                <div class="dropdown-menu">
                    <ul>
                        <?php if($est_connecte) { ?>
                            <li><a href="/coliscomp1/template/profil.php"><?php echo $Prenom; ?></a></li>
                            <li><a href="/coliscomp1/Controlleur/deconnexion.php">Se déconnecter</a></li>
                        <?php } else { ?>
                            <li><a href="/coliscomp1/template/connexion.php">Se connecter</a></li>
                        <?php } ?>
                    </ul>
                </div>
            </li>
            <li class="notification-icon">
                <a href="/coliscomp1/template/notifications.php"><i class="fas fa-bell"></i>
                    <?php if ($notifications_count > 0): ?>
                        <span class="notification-count"><?php echo $notifications_count; ?></span>
                    <?php endif; ?>
                </a>
            </li>
            <li><a href="/coliscomp1/template/fcontact.php">Contact</a></li>
        </ul>
    </div>
</body>
</html>
