
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil de l'utilisateur</title>
    <link rel="stylesheet" href="../css/styless.css">
    <script>
        function enableEditing(field) {
            document.getElementById(field + '_span').style.display = 'none';
            document.getElementById(field + '_input').style.display = 'inline-block';
            document.getElementById(field + '_edit').style.display = 'none';
            document.getElementById(field + '_save').style.display = 'inline-block';
            document.getElementById(field + '_cancel').style.display = 'inline-block';
        }

        function disableEditing(field) {
            document.getElementById(field + '_span').style.display = 'inline-block';
            document.getElementById(field + '_input').style.display = 'none';
            document.getElementById(field + '_edit').style.display = 'inline-block';
            document.getElementById(field + '_save').style.display = 'none';
            document.getElementById(field + '_cancel').style.display = 'none';
        }

        function cancelEditing(field) {
            document.getElementById(field + '_input').value = document.getElementById(field + '_span').innerText;
            disableEditing(field);
        }
    </script>
<?php
session_start(); // Démarrer la session

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['utilisateur_id'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: login.php");
    exit();
}

// Connexion à la base de données
$servername = "localhost"; // Remplace par ton serveur
$username = "root"; // Remplace par ton nom d'utilisateur
$password = ""; // Remplace par ton mot de passe
$dbname = "coliscomp"; // Nom de la base de données

// Créer la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ID de l'utilisateur connecté
$user_id = $_SESSION['utilisateur_id'];

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_email = $_POST['email'];
    $new_telephone = $_POST['numero_telephone'];
    $new_adresse = $_POST['adresse'];

    // Préparer et exécuter la requête de mise à jour
    $sql_update = "UPDATE utilisateur SET Email = ?, NumeroTelephone = ?, Adresse = ? WHERE ID = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sssi", $new_email, $new_telephone, $new_adresse, $user_id);
    $stmt_update->execute();
}

// Préparer et exécuter la requête pour récupérer les informations de l'utilisateur
$sql = "SELECT * FROM utilisateur WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Vérifier si l'utilisateur existe
if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "Utilisateur non trouvé.";
    exit();
}
?>
</head>
<body>
    <div class="profile-container">
        <h1>Profil de l'utilisateur</h1>
        <div class="profile-item">
            <label>Nom :</label>
            <span><?php echo htmlspecialchars($user['Nom']); ?></span>
        </div>
        <div class="profile-item">
            <label>Prénom :</label>
            <span><?php echo htmlspecialchars($user['Prenom']); ?></span>
        </div>
        <form method="POST">
            <div class="profile-item">
                <label>Email :</label>
                <span id="email_span"><?php echo htmlspecialchars($user['Email']); ?></span>
                <input type="email" id="email_input" name="email" value="<?php echo htmlspecialchars($user['Email']); ?>" style="display:none;">
                <button type="button" id="email_edit" onclick="enableEditing('email')">Modifier</button>
                <button type="submit" id="email_save" style="display:none;" onclick="disableEditing('email')">Enregistrer</button>
                <button type="button" id="email_cancel" style="display:none;" onclick="cancelEditing('email')">Annuler</button>
            </div>
            <div class="profile-item">
                <label>Numéro de Téléphone :</label>
                <span id="numero_telephone_span"><?php echo htmlspecialchars($user['NumeroTelephone']); ?></span>
                <input type="text" id="numero_telephone_input" name="numero_telephone" value="<?php echo htmlspecialchars($user['NumeroTelephone']); ?>" style="display:none;">
                <button type="button" id="numero_telephone_edit" onclick="enableEditing('numero_telephone')">Modifier</button>
                <button type="submit" id="numero_telephone_save" style="display:none;" onclick="disableEditing('numero_telephone')">Enregistrer</button>
                <button type="button" id="numero_telephone_cancel" style="display:none;" onclick="cancelEditing('numero_telephone')">Annuler</button>
            </div>
            <div class="profile-item">
                <label>Adresse :</label>
                <span id="adresse_span"><?php echo nl2br(htmlspecialchars($user['Adresse'])); ?></span>
                <textarea id="adresse_input" name="adresse" style="display:none;"><?php echo htmlspecialchars($user['Adresse']); ?></textarea>
                <button type="button" id="adresse_edit" onclick="enableEditing('adresse')">Modifier</button>
                <button type="submit" id="adresse_save" style="display:none;" onclick="disableEditing('adresse')">Enregistrer</button>
                <button type="button" id="adresse_cancel" style="display:none;" onclick="cancelEditing('adresse')">Annuler</button>
            </div>
            <div class="profile-item">
                <label>Rôle :</label>
                <span><?php echo htmlspecialchars($user['Role']); ?></span>
            </div>
        </form>
        <a href="../index.php" class="home-button">Retour à l'accueil</a>
    </div>
</body>
</html>
