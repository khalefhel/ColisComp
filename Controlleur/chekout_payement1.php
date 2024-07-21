<?php
// Activer l'affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . "/../vendor/autoload.php";
$stripe_secret_key = "sk_test_51PIATJP3qQoNZDTZdtDhTKi8JYRkJdFH84YUFYT7WypsbmBueOv8cDuoMYw4cwgcDCtO3GD7qMeACz8yxcWXzNkU00CvnKf8W9";

\Stripe\Stripe::setApiKey($stripe_secret_key);

// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur_id'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: login.php");
    exit();
}

// Vérifier les données POST et récupérer le budget
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['annonce_id']) && isset($_POST['budget'])) {
        $annonce_id = $_POST['annonce_id'];
        $budget = $_POST['budget'];

        // Debug: afficher les valeurs POST
        echo "annonce_id: $annonce_id, budget: $budget <br>";

        try {
            // Créer une session de paiement
            $session = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => 'Paiement pour l\'annonce ' . $annonce_id,
                        ],
                        'unit_amount' => $budget * 100, // Le montant en centimes
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => 'http://localhost/coliscomp1/Controlleur/transaction1.php?annonce_id=' . $annonce_id,
                'cancel_url' => 'https://votre-site.com/cancel',
            ]);

            // Debug: afficher l'URL de session Stripe
            echo "Rediriger vers : " . $session->url;

            // Rediriger vers la page de paiement Stripe
            header('Location: ' . $session->url);
            exit;
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        }
    } else {
        echo 'Données invalides pour le paiement.';
    }
} else {
    echo 'Méthode de requête invalide.';
}
?>
