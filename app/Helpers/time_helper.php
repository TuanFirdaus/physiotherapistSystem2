<?php

if (!function_exists('timeAgo')) {
    function timeAgo($datetime)
    {
        $timestamp = strtotime($datetime);
        $diff = time() - $timestamp;

        if ($diff < 60) return $diff . " seconds ago";
        $diff = round($diff / 60);
        if ($diff < 60) return $diff . " minutes ago";
        $diff = round($diff / 60);
        if ($diff < 24) return $diff . " hours ago";
        $diff = round($diff / 24);
        if ($diff < 7) return $diff . " days ago";
        $diff = round($diff / 7);
        if ($diff < 4) return $diff . " weeks ago";
        return date('F j, Y', $timestamp);
    }
}
