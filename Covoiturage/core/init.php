<?php

require_once 'classes/DB.php';
require_once 'classes/Session.php';

require_once 'classes/Functions.php';

// connecte bdd
$db = new DB();
$db->connect();
$db->set_char('utf8');

$_DOMAIN = 'http://localhost/Covoiturage/';

date_default_timezone_set('Europe/Paris');
$date_current = date("Y-m-d H:i:s");

$_DEPART = '';
$_ARRIVE = '';

/* Initialiser session */
$session = new Session();
$session->start();

/* Vérifier session */
if ($session->get() != '') {
    $user = $session->get();
}
else {
    $user = '';
}

if ($user) {
    // prendre les données de l'utilisateur
    $sql_get_data_user = "SELECT * FROM compte WHERE username = '$user'";
    if ($db->num_rows($sql_get_data_user)) {
        $data_user = $db->fetch_assoc($sql_get_data_user, 1);
    }
}