<?php

$path = 'assets/img/';
$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $MIMEVERIF = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png", 'bmp' => 'image/bmp', 'tiff|tif' => 'image/tiff', 'ico' => 'image/x-icon');

    if ($_FILES['file']['error'] == 4) {
        $message = ' Aucun fichier n\'a été téléchargé.';
    } else {
        $filetmpname = $_FILES["file"]["tmp_name"];
        $filemime = mime_content_type($filetmpname);

        if (in_array($filemime, $MIMEVERIF)) {

            if (isset($_FILES["file"]) && $_FILES['file']['error'] == 0) {

                $filename =  $_FILES["file"]["name"];
                $filetype = $_FILES["file"]["type"];
                $filesize = $_FILES["file"]["size"];
                $filestmp = $_FILES["file"]["tmp_name"];
                $fileserror = $_FILES["file"]["error"];
                $extension = pathinfo($filename, PATHINFO_EXTENSION);

                $sizeUpload = 3 * 1024 * 1024;
                if ($filesize > $sizeUpload) {
                    $message = "La taille de l'image est supérieure à 3 Mo, veuillez réessayer ";
                } else if (in_array($filetype, $MIMEVERIF)) {

                    move_uploaded_file($filestmp, $path . uniqid() . '.' .  $extension);
                    $message = "Votre image a été téléchargé avec succès.";
                } else {
                    $message = " Il y a eu un problème de téléchargement de votre image. Veuillez réessayer.";
                }
            }
        } else {
            $message = 'Votre Format de fichier ou taille (Max 2 Mo) n\'est pas le bon ';
        }
    }
}


?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TP-Upload_img</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>


    <header>
        <div id="pres">
            <h1>Upload ton image</h1>
        </div>

    </header>

    <div id="container-global">

        <div id="container">

            <h2>Upload une image :</h2>
            <p id="alertmess"><?= $message ?></p>


            <div id="container-mid">

                <div id="container-mid-img">
                    <img src="" alt="" class="preview">
                </div>

                <form action="index.php" method="POST" enctype="multipart/form-data">


                    <input type="submit" name="upload" value="upload" id="uploadbtn">
                    <input type="file" data-preview=".preview" name="file" id="file" value="100000">
                </form>
            </div>

            <div id="container-bottom">
                <a href="database.php" id="btn-gallerie">Galerie</a>
            </div>

        </div>


    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="assets/js/uploadPreview.js"></script>

</body>

</html>