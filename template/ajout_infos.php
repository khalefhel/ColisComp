<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une pièce d'identité et un RIB</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .container {
            margin-top: 50px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .btn {
            margin-top: 20px;
        }
        .card {
            padding: 20px;
        }
    </style>
</head>
<body class="body">
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="card">
                <h2 class="card-title text-center">Ajouter une pièce d'identité et un RIB</h2>
                <form action="../Controlleur/upload_documents.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="identite">Pièce d'identité (format PDF ou image):</label>
                        <input type="file" class="form-control-file" id="identite" name="identite" accept=".pdf, .jpg, .jpeg, .png" required>
                    </div>
                    <div class="form-group">
                        <label for="rib">RIB (format PDF ou image):</label>
                        <input type="file" class="form-control-file" id="rib" name="rib" accept=".pdf, .jpg, .jpeg, .png" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Soumettre</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
</body>
</html>
