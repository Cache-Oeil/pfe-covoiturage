<?php

require_once 'core/init.php';

if (isset($_POST['trajet'])) {

    $trajet = trim(addslashes(htmlspecialchars($_POST['trajet'])));

    if ($trajet == '') {
        echo 'error';
    } else {
        $passenger = $data_user['id_compte'];
        $sql_check_reserv = "SELECT id_passager, id_trajet FROM reservation WHERE id_passager = '$passenger' AND id_trajet = '$trajet'";
        if (!$db->num_rows($sql_check_reserv)) {
            $sql_reserver = "INSERT INTO reservation VALUES (
                      '',
                      '$passenger',
                      '$trajet',
                      ''
                )";
            $db->query($sql_reserver);
            $sql_update_nb_place = "UPDATE trajet SET places = places - 1 WHERE id_trajet = '$trajet' AND places >= 1";
            $db->query($sql_update_nb_place);
            $db->close();
            new Redirect($_DOMAIN.'mes-reservations');
        } else {
            echo 'warning';
        }
    }
}
else if (isset($_POST['id_reservation']) && isset($_POST['statut'])) {
    $id_reservation = $_POST['id_reservation'];
    $statut = $_POST['statut'];

    $sql_update_statut = "UPDATE reservation SET statut = '$statut' WHERE id_reservation = '$id_reservation'";
    $db->query($sql_update_statut);
    $sb->close();
}
else {
    echo 'error';
}