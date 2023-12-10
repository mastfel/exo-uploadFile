<?php
$uploadFile = '';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (!empty($_FILES['avatar']['name'])) {
        $uploadDir = 'uploads/';
        $extension = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
        $uniqueFilename = uniqid();
        $uploadFile = $uploadDir . $uniqueFilename . '.' . $extension;
        $authorizedExtensions = ['jpg', 'png', 'gif', 'webp'];
        $maxFileSize = 1000000;

        if (!in_array($extension, $authorizedExtensions)) {
            $errors[] =  'Extension de fichier non autorisée.';
        }

        if (file_exists($_FILES['avatar']['tmp_name']) && filesize($_FILES['avatar']['tmp_name']) > $maxFileSize) {
            $errors[] = 'La taille du fichier dépasse la limite autorisée';
        }

        if (empty($errors)) {
            move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
        }
    }
} else if (isset($_POST['action']) && $_POST['action'] === 'delete') {
    if (file_exists($_POST['file'])) {
        unlink($_POST['file']);
        echo "unlink: {$file}\n";
    }
}

?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=
    , initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Document</title>
</head>

<body>

    <form action="form.php" method="post" enctype="multipart/form-data">
        <label for="imageUpload">Télécharger une image de profil</label>
        <input type="file" name="avatar" id="imageUpload" />
        <button name="send" style=" border: solid yellow;">Télécharger</button>
        <div>
    </form>
    <?php
    if (!empty($errors)) {
        echo '<div class="alert alert-danger" role="alert">';
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        echo '</div>';
    }
    ?>
    <div class="card container d-flex justify-content-center align-items-center " style="width:450px;background-color:lightgray;">
        <h1 class="card-title bg-info "> SPRINGFIELD, IL</h1>
        <div class="row no-gutters">
            <div class="col-md-4">
                <img class="card-img-top bg-info" style="height:80%;" src="<?= $uploadFile ?>" alt="Picture-homer">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <h2 class="card-title bg-info">driving license</h2>
                    <h4 class="card-title">HOMER SIMPSON</h4>
                    <h4 class="card-title">69 Old Plumtree Blvd</h4>
                    <h4 class="card-title">Springfield, IL 62701</h4>
                    <h6 class="card-title">HOMER SIMPSON</h6>
                    <hr>
                    <p class="card-title" style="font-size: x-small; margin:0%">SIGNATURE</p>
                </div>
            </div>
        </div>
    </div>
    <div class="container d-flex justify-content-center align-items-center ">
        <form action="form.php" method="post">
            <input type="hidden" name="_method" value="delete">
            <input type="hidden" name="file" value="<?= $uploadFile ?>">
            <button type="submit" name="send" style="border: solid red;">Supprimer</button>
        </form>
    </div>
    <?php
    
    ?>
</body>

</html>