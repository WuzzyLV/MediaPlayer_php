<?php 
use Wuzzy\MusicPlayer\SongManager\SongManager;
use Wuzzy\MusicPlayer\Database\User;

$user = new User();
$songManager = new SongManager();

$songs = $songManager->getAllSongs(
    $user->getIDByUsername($_SESSION['username'])
);
//remove serverside info
foreach ($songs as $key => $song) {
    unset($songs[$key]['user_id']);
    unset($songs[$key]['path']);
}

?>
<div class="songs">
    <table class="">
        <thead>
            <tr>
                <th>Artist</th>
                <th>Title</th>
                <th>Crated at</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($songs as $song): ?>
                <tr>
                    <td><?php echo $song['artist']; ?></td>
                    <td><?php echo $song['title']; ?></td>
                    <td><?php echo $song['created_at']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

