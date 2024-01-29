<?php
namespace Wuzzy\MusicPlayer\Utils;

class TimeUtils {
    public static function timeDiffToString($date1, $date2) {
        $date = new \DateTime($date1);
        $diff = $date->diff($date2);
        if ($diff->y > 0) {
            echo $diff->y . " years ago";
        } elseif ($diff->m > 0) {
            echo $diff->m . " months ago";
        } elseif ($diff->d > 0) {
            echo $diff->d . " days ago";
        } elseif ($diff->h > 0) {
            echo $diff->h . " hours ago";
        } elseif ($diff->i > 0) {
            echo $diff->i . " minutes ago";
        } else {
            echo "just now";
        }
    }
}