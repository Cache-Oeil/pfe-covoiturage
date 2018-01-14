<?php

require_once 'core/init.php';

if (isset($_POST['id_trajet'])) {

    $id_trajet = $_POST['id_trajet'];
    $passager = $data_user['id_compte'];

    if ($id_trajet == '') {
        echo 'error';
    } else {

        $sql_delete_reserv = "DELETE FROM reservation WHERE id_passager = '$passager' AND id_trajet = '$id_trajet'";
        $db->query($sql_delete_reserv);
        $sql_update_nb_place = "UPDATE trajet SET places = places + 1 WHERE id_trajet = '$id_trajet' AND places <= 3";
        $db->query($sql_update_nb_place);
        $db->close();
    }
}
else if (isset($_POST['id_reservation'])) {
    $id_reservation = $_POST['id_reservation'];
    if ($id_reservation == '') {
        echo 'error';
    }
    else {
        $sql_id_trajet = "SELECT * FROM reservation WHERE id_reservation = '$id_reservation'";
        if ($db->num_rows($sql_id_trajet)) {
            $id_trajet = $db->fetch_assoc($sql_id_trajet, 1)['id_trajet'];
        }
        $sql_delete_reserv = "DELETE FROM reservation WHERE id_reservation = '$id_reservation'";
        $db->query($sql_delete_reserv);
        $sql_update_nb_place = "UPDATE trajet SET places = places + 1 WHERE id_trajet = '$id_trajet' AND places <= 3";
        $db->query($sql_update_nb_place);
        $db->close();
    }
}
else {
    echo 'error';
}