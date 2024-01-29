var song;
var playing = false;

function getSong(autoplay) {
    console.log("getting song");
    if (song) {
        song.unload();
    }
    song = new Howl({
        src: ['/api/playsong'],
        autoplay: autoplay,
        loop: false,
        preload: true,
        format: ['mp3']
    });
    song.volume($("#volume").val()/100);
    $("#seekBar").val(0);
}
getSong(false);
//init
$(function() {
    var volume = $("#volume").val();
    $("#volumeDisplay").text(volume);
    song.volume(volume/100);

});


$("#play").on("click", function() {
    $(document).trigger("playSong");
});
$("#pause").on("click", function() {
    $(document).trigger("pauseSong");
});
$("#next").on("click", function() {
    $(document).trigger("nextSong");
});
$("#previous").on("click", function() {
    $(document).trigger("previousSong");
});

//handle volume
$("#volume").on("input", function() {
    console.log($(this).val());
    song.volume($(this).val()/100);
    $("#volumeDisplay").text($(this).val());
});

$("#seekBar").on("input", function() {
    var seekPosition = song.duration() * (this.value / 100);
    song.seek(seekPosition);
});

setInterval(function() {
    var seekPosition = song.seek() || 0;
    var seekPercentage = (seekPosition / song.duration()) * 100;
    $("#seekBar").val(seekPercentage);
}, 100);


$(document).on("reloadSong", function() {
    playing = true;
    getSong(true);
});

$(document).on("playSong", function() {
    if (playing) return;
    song.play();
    playing = true;
});

$(document).on("pauseSong", function() {
    if (!playing) return;
    playing = false;
    song.pause();
});

$(document).on("nextSong", function() {
    $.get("/api/nextsong");
    $(document).trigger("reloadSong");
});

$(document).on("previousSong", function() {
    $.get("/api/rewindsong");
    $(document).trigger("reloadSong");
});
