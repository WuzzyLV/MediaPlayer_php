<?php
use Wuzzy\MusicPlayer\SongManager\SongUploader;

$errors;

if (isset($_POST['submit'])) {
    $songUploader = new SongUploader();

    $errors = $songUploader->uploadSong($_FILES['song']);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
</head>
<body>
    <?php require COMP_PATH . 'Navbar.php'; ?>
    
    <?php
        if (isset($errors) && $errors->hasErrors()){
            foreach ($errors->getErrors() as $error) {
                echo $error . '<br>';
            }
        }
    ?>

    <form action="/upload" method="post" enctype="multipart/form-data">
        <input type="file" name="song" id="song">
        <input type="submit" value="Upload song" name="submit">
    </form>
</body>
</html>