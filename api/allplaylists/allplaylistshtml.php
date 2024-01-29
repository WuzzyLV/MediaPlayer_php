<?php
use Wuzzy\MusicPlayer\Playlist\PlaylistManager;
use Wuzzy\MusicPlayer\Database\User;
use Wuzzy\MusicPlayer\Utils\TimeUtils;

$user = new User();
$playlistManager = new PlaylistManager();

$playlists = $playlistManager->getAllPlaylists(
    $user->getIDByUsername($_SESSION['username'])
);

//remove serverside info
foreach ($playlists as $key => $playlist) {
    unset($playlists[$key]['user_id']);
}
?>


<?php foreach ($playlists as $playlist): ?>
    <div class="playlist">
        <div class="playlist-title">
            <h3><?php echo $playlist["name"]; ?></h3>
            <p><?php TimeUtils::timeDiffToString($playlist["created_at"], new DateTime()); ?></p>
        </div>
        <div class="playlist-songs">
            <?php foreach ($playlist["songs"] as $song): ?>
                <div class="playlist-song">
                    <p><?php echo $song["title"]; ?></p>
                    <p><?php echo $song["artist"]; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <button data-id="<?php echo $playlist["id"] ?>" class="playPlaylist">Play</button>
    </div>
<?php endforeach; ?>