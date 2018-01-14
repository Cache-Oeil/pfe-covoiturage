<?php

require_once 'core/init.php';

if (isset($_POST['id_trajet'])) {
    $id_trajet = $_POST['id_trajet'];
    $conducteur = $data_user['id_compte'];

    if ($id_trajet == '') {
        echo 'error';
    } else {
        $sql_delete_annonce = "DELETE FROM trajet WHERE id_conducteur = '$conducteur' AND id_trajet = '$id_trajet'";
        $db->query($sql_delete_annonce);
        $db->close();
    }
} else {
    echo 'error';
}
