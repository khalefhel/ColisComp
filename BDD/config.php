<?
// Connexion à la base de données (vous devez inclure votre fichier de configuration de base de données ici)
    $connexion = new mysqli("localhost", "root", "", "coliscomp");

    // Vérifier la connexion
    if ($connexion->connect_error) {
        die("Erreur de connexion à la base de données : " . $connexion->connect_error);
    }