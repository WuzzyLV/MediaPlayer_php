function createPlaylists(){
    $.ajax({url: "/api/allplaylistshtml", method: "GET"}).then(function(data) {
        $(".playlists").html(data);
    });
}

createPlaylists();


$(".playlists").on("click", ".playPlaylist", function() {
    $.post(
        "/api/playplaylist", 
        {
            id: $(this).attr("data-id")
        }
    ).then(function(data) {
        $(document).trigger("reloadSong");
    });
});