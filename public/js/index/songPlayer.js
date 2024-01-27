var song = new Howl({
    src: ['/api/playsong'],
    autoplay: false,
    loop: false,
    preload: true,
    format: ['mp3']
});

$("#play").on("click", function() {
    console.log(song.state());
    song.play();
});

$(".playlists").on("click", ".playPlaylist", function() {
    $.post(
        "/api/playplaylist", 
        {
            id: $(this).attr("data-id")
        }
    ).then(function(data) {
        console.log(data);
    });
});

function playCurrentSong(){

}

function setRandomSongURL() {
    var uniqueSongUrl = "/api/playsong" + '?' + new Date().getTime(); // Use timestamp
    $("#audioPlayer").attr("src", uniqueSongUrl);
}

setRandomSongURL();