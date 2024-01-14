
$(document).on("submit", "#newPlaylistForm", function(event) {

    var newPlaylist = {
        name: $("#newPlaylistForm [name=name]").val().trim(),
        songs: []
    };

    $("#newPlaylistForm [name=song]:checked").each(function() {
        newPlaylist.songs.push($(this).val());
    });

    $.post("/api/newplaylist", newPlaylist).then(function(data) {
        console.log(data);
    });

    $(".allsongs").empty();
    createPlaylists();
    event.preventDefault();
});

$("#newPlaylist").on("click", function() {
    $.get("/api/allsongs").then(function(data) {
        createForm(data);
    });
});

function createForm(data) {
    var form = $("<form>");
    form.attr("method", "post");
    form.attr("action", "/playlists");
    form.attr("id", "newPlaylistForm");

    var input = $("<input>");
    input.attr("type", "text");
    input.attr("name", "name");
    input.attr("placeholder", "Playlist Name");
    form.append(input);

    form.append($("<br>"));

    //add to page form
    data.forEach(element => {
        var label = $("<label>");
        label.text(element.title);
        form.append(label);

        var input = $("<input>");
        input.attr("name", "song");
        input.attr("value", element.id);
        input.attr("type", "checkbox");
        
        form.append(input);

        form.append($("<br>"));
    });

    var submit = $("<input>");
    submit.attr("type", "submit");
    submit.attr("value", "Submit");
    form.append(submit);

    
    $(".allsongs").html(form);
}

function createPlaylists(){
    $.get("/api/allplaylists").then(function(data) {
        $(".playlists").empty();

        data.forEach(element => {
            var playlist = $("<div>");
            var title = $("<h3>");
            title.text(element.name);
            playlist.append(title);
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
