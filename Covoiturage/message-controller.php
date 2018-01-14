<?php

require_once 'core/init.php';

if (isset($_POST['recepteur']) && isset($_POST['texte'])) {

    $emetteur = $data_user['id_compte'];
    $recepteur = trim(addslashes(htmlspecialchars($_POST['recepteur'])));
    $texte = trim(addslashes(htmlspecialchars($_POST['texte'])));

    if ($recepteur == '' || $texte == '') {
        echo 'error';
    } else {
        $sql_recepteur = "SELECT * FROM compte WHERE username = '$recepteur'";
        if ($db->num_rows($sql_recepteur)) {
            $recepteur = $db->fetch_assoc($sql_recepteur, 1)['id_compte'];
            $sql_send_mess = "INSERT INTO message VALUES(
                    '',
                    '$emetteur',
                    '$recepteur',
                    '$texte',
                    '$date_current',
                    ''
            )";
            $db->query($sql_send_mess);
            $db->close();
            new Redirect($_DOMAIN.'mes-messages/nouveau-message');
        }
    }
} else {
    echo 'error';
}

if (isset($_GET['id_message'])) {
    $id_message = $_GET['id_message'];

}