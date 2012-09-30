<?php

function sec2hms($sec, $padHours = FALSE) {
    $hms = "";
    $hours = intval(intval($sec) / 3600);
    $hms .= ( $padHours) ? str_pad($hours, 2, "0", STR_PAD_LEFT) . ":" : $hours . ":";
    $minutes = intval(($sec / 60) % 60);
    $hms .= str_pad($minutes, 2, "0", STR_PAD_LEFT) . ":";
    $seconds = intval($sec % 60);
    $hms .= str_pad($seconds, 2, "0", STR_PAD_LEFT);
    return $hms;
}

function sec2h($sec) {
    $h = "";
    $h = $sec / 3600;
    return $h;
}

function _sec2tspan($sec, $padHours = false) {
    $tspan = "";
    $hours = intval(intval($sec) / 3600);
    $tspan .= $hours . ' ' . ($hours > 1 ? lang('date_hours') : lang('date_hour'));
    $minutes = intval(($sec / 60) % 60);
    $tspan .= ', ' . $minutes . ' ' . ($minutes > 1 ? lang('date_minutes') : lang('date_minute'));
    //        $seconds = intval($sec % 60);
    //        $tspan .= ', '.$seconds . ' ' . ($seconds>1 ? lang('date_seconds') : lang('date_second'));
    return $tspan;
}

?>
