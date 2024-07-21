<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Annonces de Colis à Transporter</title>
    <link rel="stylesheet" href="../css/contact.css">
</head>

<body>
  <?php include '../template/header.php'
  ?>
  
  <!--
  Question : 
  https://openclassrooms.com/forum/sujet/formulaire-de-contact-responsive
  -->
  <div class="container">
    <h1>Formulaire de contact</h1>
    <form action="/action_page.php">
      <label for="fname">Nom & prénom</label>
      <input type="text" id="fname" name="firstname" placeholder="Votre nom et prénom">
  
      <label for="sujet">Sujet</label>
      <input type="text" id="sujet" name="sujet" placeholder="L'objet de votre message">
  
      <label for="emailAddress">Email</label>
      <input id="emailAddress" type="email" name="email" placeholder="Votre email">
  
  
      <label for="subject">Message</label>
      <textarea id="subject" name="subject" placeholder="Votre message" style="height:200px"></textarea>
  
      <input type="submit" value="Envoyer">
    </form>
  </div>
</body>
</html>

