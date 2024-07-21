<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>coliscomp - Bienvenue</title>
    <link rel="stylesheet" href="css/home.css">
    <link rel="icon" href="icon.png">
</head>
<body>
    <?php include 'template/header.php'?>

    <div class="wrapper">
        
    <div style="display: flex; justify-content: center;">
    <img src="css/Images/icon.svg" alt="icon.svg" width="1000" height="600">
</div>
        
        <section id="about" class="sec-about">
            <div class="container">
                <h1>À PROPOS DE COLISCOMP </h1>
                <hr />
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">
                        <p>Coliscomp est une plateforme de covoiturage des colis qui met en relation des personnes qui souhaitent envoyer ou recevoir des colis avec des automobilistes qui effectuent des trajets similaires. Le service est disponible pour tous, sans frais d'inscription ni frais de livraison cachés.         
                </div>
            </div>
        </section>
        
        <section id="services" class="sec-services">
            <div class="container">
                <h1>Services</h1>
                <hr />
                <div class="row">
                    <div class="col-sm-4 service-fiable">
                        <img src="css/images/service_fiable.png" alt="Service Fiable" class="icon">
                        <h2 class="h3">Service fiable</h2>
                    </div>
                    <div class="col-sm-4 service-rapide">
                        <img src="css/images/livraisonRapide.png" alt="Livraison Rapide" class="icon">
                        <h2 class="h3">Livraison rapide</h2>
                    </div>
                    <div class="col-sm-4 service-abordable">
                        <img src="css/images/prixAbordable.png" alt="Prix Abordable" class="icon">
                        <h2 class="h3">Prix abordable</h2>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="how-it-works" class="sec-how-it-works">
            <div class="container">
                <h1>Comment ça marche ?</h1>
                <hr />
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <p>Pour utiliser Coliscomp, il suffit de créer un compte sur le site Web ou l'application mobile. Ensuite, vous pouvez poster une annonce pour votre colis, en indiquant le type de colis, sa taille, son poids, et sa destination. Les automobilistes qui effectuent des trajets similaires seront alors avertis de votre annonce.</p>
                        <p>Si un automobiliste est intéressé par votre colis, vous pouvez discuter des détails de la livraison. Une fois que vous êtes d'accord sur les modalités, vous pouvez confirmer la réservation.</p>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="stats" class="sec-stats">
            <div class="container">
                <h2>Nos chiffres clés</h2>
                <hr />
                <div class="row">
                    <div class="col-sm-4">
                        <div class="stat-item">
                            <i class="fas fa-box"></i>
                            <h3>10,000+</h3>
                            <p>Colis livrés</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="stat-item">
                            <i class="fas fa-users"></i>
                            <h3>5,000+</h3>
                            <p>Utilisateurs actifs</p>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="stat-item">
                            <i class="fas fa-globe"></i>
                            <h3>France</h3>
                            <p>Pays desservis</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="faq" class="sec-faq">
            <div class="container">
                <h2>FAQ</h2>
                <hr />
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <h3>Comment fonctionne le covoiturage de colis ?</h3>
                        <span class="faq-arrow">&#9660;</span>
                    </div>
                    <div class="faq-answer">
                        <p>Le covoiturage de colis permet aux expéditeurs de trouver des transporteurs de confiance qui peuvent livrer leurs colis. Les utilisateurs peuvent poster une annonce de transport ou chercher des annonces existantes.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <h3>Quels sont les coûts associés ?</h3>
                        <span class="faq-arrow">&#9660;</span>
                    </div>
                    <div class="faq-answer">
                        <p>Les coûts varient en fonction de la distance, de la taille du colis et des conditions du transporteur. Vous pouvez obtenir un devis en ligne via notre plateforme.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-question" onclick="toggleFaq(this)">
                        <h3>Comment assurer la sécurité de mes colis ?</h3>
                        <span class="faq-arrow">&#9660;</span>
                    </div>
                    <div class="faq-answer">
                        <p>Nous vérifions tous nos transporteurs et utilisons des mesures de suivi pour garantir que votre colis arrive en toute sécurité. De plus, nous offrons des options d'assurance pour plus de tranquillité d'esprit.</p>
                    </div>
                </div>
            </div>
        </section>
        
        <footer id="footer">
            <div class="container">
                <p>&copy; 2024 Coliscomps. Tous droits réservés.</p>
                <ul class="soc-media-ul">
                    <li>
                        <a href="https://twitter.com/AlexDevero" class="fa fa-twitter" target="_blank" aria-label="Twitter"></a>
                    </li>
                    <li>
                        <a href="https://plus.google.com/u/0/+AlexDevero" class="fa fa-google-plus" target="_blank" aria-label="Google Plus"></a>
                    </li>
                    <li>
                        <a href="https://cz.linkedin.com/pub/alex-devero/38/262/70/" class="fa fa-linkedin" target="_blank" aria-label="LinkedIn"></a>
                    </li>
                    <li>
                        <a href="https://www.behance.net/d3v3r0" class="fa fa-behance" target="_blank" aria-label="Behance"></a>
                    </li>
                    <li>
                        <a href="mailto:example@mail.com" class="fa fa-envelope" aria-label="Email"></a>
                    </li>
                </ul>
            </div>
        </footer>
        
    </div>
     <script src="JS/index.js" defer></script>
</body>
</html>