<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>coliscomp</title>
  <link rel="stylesheet" href="../css/style_envoie.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="icon" href="../images/icon.png">
</head>
<body>
  <div class="navbar">
    <a href="../index.php"><img src="../images/logo.png" class="logo"></a>
    <ul>
      <li><a href="send_colis.php"><i class="fa-solid fa-chevron-down"></i>Transporteur</a></li>
      <li><a href="tarif.php"><i class="fa-solid fa-box"></i>Expéditeur</a></li>
      <li><a href="#"><i class="fa-solid fa-magnifying-glass"></i>Voir les annonces</a></li>
      <li><a href="login.php"><i class="fa-solid fa-user"></i>Mon compte</a></li>
    </ul>
  </div>
  <!-- Ajout du texte "Tarifs" à droite de "Envoyer des objets" -->
  <div class="tarifs">
    <p><strong>Enoyer des objets </strong></p>
    <p><strong class="tarif-text">Tarifs</strong></p>&ensp;
    <i class="fa-solid fa-chevron-down"></i>
  </div>
  <div class="orange-square">
    <div class="square-text">
      <p >Quantité</p>
      <p>Nom d'objet</p>
    </div>
    <div class="group">
      <input type="text" id="quantity">
      <input type="text" id="objectName">
    </div>
    <p class="size-text"><strong>Taille de l'objet :</strong></p>
    <div class="radio-group">
      <div>
        <input type="radio" id="huey" name="drone" value="huey"/>
        <label for="huey"> Taille S</label>
      </div>
      <div>
        <input type="radio" id="dewey" name="drone" value="dewey"/>
        <label for="dewey">Taille M</label>
      </div>
      <div>
        <input type="radio" id="louie" name="drone" value="louie"/>
        <label for="louie">Taille L</label>
      </div>
      <div>
        <input type="radio" id="louie" name="drone" value="louie"/>
        <label for="louie">Taille XL</label>
      </div>
    </div>
    <p class="weight-text"><strong>Poids :</strong></p>
    <table class="custom-table">
      <tr>
        <td class="small-cell"> -5 Kg</td>
        <td class="medium-cell"> 5 à 30 Kg</td>
        <td class="large-cell">30 à 100 Kg</td>
      </tr>
    </table>
    <p class="photo-text"><strong>Photo :</strong></p>
    <div class="photo-section">
      <p>Mettez en valeur votre annonce ! Attirez l'attention avec quelques photos montrant l'objet à transporter.</p>
      <p>Une annonce avec photo est 7 fois plus consultée que sans photo.</p>
    </div>
    <div class="white-section">
      <i class="fas fa-camera"></i>
      <p>Cliquez ici pour sélectionner vos fichiers ou glissez-les dans cette zone</p>
      <strong><p>Nous acceptons les documents JPG, PNG et GIF jusqu'à 7 MB.</p></strong>
    </div>
  </div>
  <div class="terms-section">
    <div class="point_section">
      <i class="fa-solid fa-circle-dot"></i>&ensp;
      <p><strong>Conditions Générales d’expédition :</strong></p>
    </div>
    <ul>
      <li><strong>&lt; Inscréption et création d'annonce</strong></li>
      <li><strong> &lt; Recherche de transporteur</strong></li>
      <li><strong> &lt; Confirmation et paiement</strong></li>
      <li><strong> &lt;Assurance et responsabilité</strong></li>
      <li><strong> &lt;  Respect des réglementations et conditions légales</strong></li>
      <li><strong> &lt; Communication et suivi</strong></li>
      <li><strong> &lt; Réception et évaluation</strong></li>
    </ul>
  </div>
  <button class="orange-button">Ajouter Un Objet</button>
  <button class="blue-button">Suivant</button>
  <footer>
    <p>&copy; 2024 coliscomp. Tous droits réservés.</p>
    </footer>
</body>
</html>