<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://code.jquery.com/jquery-3.7.1.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.2.4/howler.min.js" defer integrity="sha512-xi/RZRIF/S0hJ+yJJYuZ5yk6/8pCiRlEXZzoguSMl+vk2i3m6UjUO/WcZ11blRL/O+rnj94JRGwt/CHbc9+6EA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="js/index/createPlaylist.js" defer></script>
    <script src="js/index/playlistList.js" defer></script>
    <script src="js/index/songPlayer.js" defer></script>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <?php
        require COMP_PATH . 'Navbar.php';
    ?>

    <button id = "newPlaylist">New Playlist</button>
    <div class="allsongs"></div>

    <div class="playlists flex"></div>


    <div class="controls">
        <button id = "rewind">Previous</button>
        <button id = "play">Play</button>
        <button id = "pause">Pause</button>
        <button id = "next">Next</button>
        <div class="volume-container">
        <input id = "volume" type="range" min = "0" max = "100" step= "1" value= "25">
        <div id="volumeDisplay"></div>
        </div>
        <div class="seekbar-container">
        <input id = "seekBar" type="range" min = "0" max = "100" step= "0.1" value= "0">
        </div>

    </div>
</body>
</html>