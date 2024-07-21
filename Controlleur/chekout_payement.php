<?php
require __DIR__ . "/../vendor/autoload.php";
$stripe_secret_key = "sk_test_51PIATJP3qQoNZDTZdtDhTKi8JYRkJdFH84YUFYT7WypsbmBueOv8cDuoMYw4cwgcDCtO3GD7qMeACz8yxcWXzNkU00CvnKf8W9";

\Stripe\Stripe::setApiKey($stripe_secret_key);

// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['utilisateur_id'])) {
    // Récupérer l'ID de l'annonce et le prix proposé depuis le formulaire
    $annonce_id = $_POST['annonce_id'];
    $prix_propose = $_POST['prix_propose'];

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
                    'unit_amount' => $prix_propose * 100, // Le montant en centimes
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => 'http://localhost/coliscomp1/Controlleur/transaction.php?annonce_id=' . $annonce_id,
            'cancel_url' => 'https://votre-site.com/cancel',
        ]);

        // Rediriger vers la page de paiement Stripe
        header('Location: ' . $session->url);
        exit;
    } catch (Exception $e) {
        echo 'Erreur : ' . $e->getMessage();
    }
} else {
    echo 'Vous devez être connecté pour effectuer un paiement.';
}
?>
