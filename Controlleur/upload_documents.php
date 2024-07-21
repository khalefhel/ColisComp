<?php
session_start();

// Connexion à la base de données
$connexion = new mysqli("localhost", "root", "", "coliscomp");

// Vérifier la connexion
if ($connexion->connect_error) {
    die("Erreur de connexion à la base de données : " . $connexion->connect_error);
}

// Vérifier si l'ID de l'utilisateur est passé dans la requête
if (isset($_SESSION['utilisateur_id'])) {
    $user_id = intval($_SESSION['utilisateur_id']);
} else {
    die("ID utilisateur manquant.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Répertoire où les fichiers seront sauvegardés
    $target_dir = "../uploads/";

    // Piece d'identité
    $identite_file = $target_dir . basename($_FILES["identite"]["name"]);
    $identiteFileType = strtolower(pathinfo($identite_file, PATHINFO_EXTENSION));

    // RIB
    $rib_file = $target_dir . basename($_FILES["rib"]["name"]);
    $ribFileType = strtolower(pathinfo($rib_file, PATHINFO_EXTENSION));

    $uploadOk = 1;

    // Check if files are actual images or PDF
    $checkIdentite = getimagesize($_FILES["identite"]["tmp_name"]);
    $checkRib = getimagesize($_FILES["rib"]["tmp_name"]);

    if ($checkIdentite !== false || $identiteFileType == "pdf") {
        $uploadOk = 1;
    } else {
        echo "Le fichier de la pièce d'identité n'est pas une image ou un PDF.";
        $uploadOk = 0;
    }

    if ($checkRib !== false || $ribFileType == "pdf") {
        $uploadOk = 1;
    } else {
        echo "Le fichier du RIB n'est pas une image ou un PDF.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Désolé, vos fichiers n'ont pas été téléchargés.";
    } else {
        if (move_uploaded_file($_FILES["identite"]["tmp_name"], $identite_file) && move_uploaded_file($_FILES["rib"]["tmp_name"], $rib_file)) {
            echo "Les fichiers ". basename($_FILES["identite"]["name"]). " et " . basename($_FILES["rib"]["name"]). " ont été téléchargés.";

            // Insérer les chemins des fichiers dans la base de données
            $identite_file = $connexion->real_escape_string($identite_file);
            $rib_file = $connexion->real_escape_string($rib_file);

            // Commencer une transaction
            $connexion->begin_transaction();

            try {
                // Mettre à jour les chemins des fichiers
                $sql = "UPDATE utilisateur SET Piece_identite='$identite_file', rib='$rib_file' WHERE ID=$user_id";
                if ($connexion->query($sql) === TRUE) {
                    // Mettre à jour le rôle de l'utilisateur
                    $sql_role = "UPDATE utilisateur SET Role='livreur' WHERE ID=$user_id";
                    if ($connexion->query($sql_role) === TRUE) {
                        // Valider la transaction
                        $connexion->commit();
                        echo "Filicitions , La vous étes connecter avec un compte de livreur cous pouvez transporter les livraisons .";
                        $_SESSION['role'] = 'livreur';
                        $connexion->close();
                        header("Location: ../template/annoncecolistrans.php");

                    } else {
                        throw new Exception("Erreur lors de la mise à jour du rôle : " . $connexion->error);
                    }
                } else {
                    throw new Exception("Erreur lors de la mise à jour des informations : " . $connexion->error);
                }
            } catch (Exception $e) {
                // Annuler la transaction
                $connexion->rollback();
                echo "Échec de la mise à jour : " . $e->getMessage();
            }
        } else {
            echo "Désolé, une erreur est survenue lors du téléchargement de vos fichiers.";
        }
    }

    // Fermer la connexion
    $connexion->close();
}
?>
