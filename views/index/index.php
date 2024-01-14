<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.7.1.js" defer></script>
    <script src="js/IndexPlaylist.js" defer></script>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <?php
        require COMP_PATH . 'Navbar.php';
    ?>

    <button id = "newPlaylist">New Playlist</button>

    <div class="flex">
        <div class="allsongs"></div>

        <div class="playlists"></div>
    </div>

</body>
</html>