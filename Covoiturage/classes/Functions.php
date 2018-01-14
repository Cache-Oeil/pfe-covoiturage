<?php

class Redirect
{
    public function __construct($url = NULL) {
        if ($url) {
            echo '<script>location.href = "' . $url . '";</script>';
        }
    }
}


function validateDate($date) {
    $d = DateTime::createFromFormat("Y-m-d H:i", $date);
    return $d && $d->format("Y-m-d H:i") == $date;
}


function date_en_fr($date) {
    $date = strtotime($date);
    $jour = array( 'dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi');
    $mois = array('janvier', 'février', 'mars', 'avril', 'mai', 'juin', 'juillet', 'août',
        'septembre', 'octobre', 'novembre', 'décembre');

    $temps = 'Le '.$jour[date("w", $date)].' '.date("d", $date).' '.$mois[date("m", $date) - 1].' '.date('Y', $date);
    return $temps;
}

function day_month_en_fr_($date) {
    $date = strtotime($date);
    $mois = array('Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc');

    $temps = date("d", $date).' '.$mois[date("m", $date) - 1];
    return $temps;
}