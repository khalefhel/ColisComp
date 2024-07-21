<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contactez-nous</title>
    <link rel="stylesheet" href="../css/fcontact.css" />
    <link rel="icon" href="icon.png" />
  </head>
  <body>
    <?php include 'header.php'?>
    <div class="contact-container">
      <h1>Contactez-nous</h1>
      <form id="contact-form">
        <div class="form-group">
          <label for="from_name">Nom</label>
          <input
            type="text"
            id="from_name"
            name="from_name"
            placeholder="Votre nom"
            required
          />
        </div>
        <div class="form-group">
          <label for="prenom">Prénom</label>
          <input
            type="text"
            id="prenom"
            name="prenom"
            placeholder="Votre prénom"
            required
          />
        </div>
        <div class="form-group">
          <label for="email">Email</label>
          <input
            type="email"
            id="email"
            name="email"
            placeholder="Votre email"
            required
          />
        </div>
        <div class="form-group">
          <label for="adresse">Adresse</label>
          <input
            type="text"
            id="adresse"
            name="adresse"
            placeholder="Votre adresse"
            required
          />
        </div>
        <div class="form-group">
          <label for="telephone">Numéro de téléphone</label>
          <input
            type="text"
            id="telephone"
            name="telephone"
            placeholder="Votre numéro de téléphone"
            required
          />
        </div>
        <div class="form-group">
          <label for="message">Message</label>
          <textarea
            id="message"
            name="message"
            placeholder="Votre message"
            required
          ></textarea>
        </div>
        <button type="submit" class="btn-submit">Envoyer</button>
      </form>
      <div id="status"></div>
    </div>

    <!-- EmailJS SDK -->
    <script
      type="text/javascript"
      src="https://cdn.emailjs.com/dist/email.min.js"
    ></script>
    <script type="text/javascript">
      (function () {
        emailjs.init("Icv6kRiR0R4NxHN3G");
      })();
    </script>

    <!-- Script pour envoyer le formulaire -->
    <script>
      document
        .getElementById("contact-form")
        .addEventListener("submit", function (event) {
          event.preventDefault();
          emailjs.sendForm("service_saqkrv3", "template_7n4935g", this).then(
            function () {
              document.getElementById("status").innerHTML =
                "Message envoyé avec succès!";
            },
            function (error) {
              document.getElementById("status").innerHTML =
                "Échec de l'envoi du message : " + JSON.stringify(error);
            }
          );
        });
    </script>
  </body>
</html>
