function createPlaylists(){
    $.get("/api/allplaylists").then(function(data) {
        $(".playlists").empty();

        data.forEach(element => {
            var playlist = $("<div>");
            var title = $("<h3>");
            title.text(element.name);
            playlist.append(title);
            //create button
            var button = $("<button>");
            button.attr("data-id", element.id);
            button.text("Play");
            button.addClass("playPlaylist");
            playlist.append(button);

            element.songs.forEach(song => {
                var songTitle = $("<p>");
                songTitle.text(song.title);
                playlist.append(songTitle);
            });

            $(".playlists").append(playlist);
        });
    });
}

createPlaylists();
