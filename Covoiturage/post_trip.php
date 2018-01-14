<?php

require_once 'core/init.php';

// se connecté
if ($user) {
    if (isset($_POST['depart_post_trip']) && isset($_POST['arrive_post_trip']) && isset($_POST['date_retour_post_trip']) &&
        isset($_POST['place_post_trip']) && isset($_POST['date_post_trip']) && isset($_POST['place_retour_post_trip']) &&
        isset($_POST['depart_lat']) && isset($_POST['depart_lng'])) {

        $conducteur = $data_user['id_compte'];
        $post_depart = trim(addslashes(htmlspecialchars($_POST['depart_post_trip'])));
        $depart_lat = $_POST['depart_lat'];
        $depart_lng = $_POST['depart_lng'];
        $post_arrive = trim(addslashes(htmlspecialchars($_POST['arrive_post_trip'])));
        $post_place = trim(addslashes(htmlspecialchars($_POST['place_post_trip'])));
        $post_place_retour = trim(addslashes(htmlspecialchars($_POST['place_retour_post_trip'])));
        $post_date = trim(addslashes(htmlspecialchars($_POST['date_post_trip'])));
        $post_date_retour = trim(addslashes(htmlspecialchars($_POST['date_retour_post_trip'])));

        $success = '<script>$("#formPostTrip #post_alert").removeClass("alert-danger").addClass("alert-success");</script>';

        $sql_check_depart = "SELECT * FROM point WHERE nom = '$post_depart' AND lat = '$depart_lat' AND lng = '$depart_lng'";
        if (!$db->num_rows($sql_check_depart)) {
            $sql_new_address = "INSERT INTO point VALUES (
                    '',
                    '$post_depart',
                    '$post_depart',
                    '$depart_lat',
                    '$depart_lng'
            )";
            $db->query($sql_new_address);
        }
        if ($conducteur == '' || $post_depart == '' || $post_arrive == '' || $post_place == '' || $post_date == '') {
            echo 'Une erreur est survenue, veuillez réessayer!';
        }
        else {
            if (!validateDate($post_date)) {
                echo 'Le format de la date de départ est faute, veuillez réessayer!';
            } else if (preg_match('/\D/', $post_place) || preg_match('/\D/', $post_place_retour)) {
                echo 'Une erreur est survenue, veuillez réessayer!';
            } else if ($post_date_retour != '' && !validateDate($post_date_retour)) {
                echo 'Le format de la date de retour est faute, veuillez réessayer!';
            } else {
                $sql_post_depart = "SELECT * FROM point WHERE adresse = '$post_depart'";
                $sql_post_arrive = "SELECT * FROM point WHERE nom = '$post_arrive'";
                if ($db->num_rows($sql_post_depart) && $db->num_rows($sql_post_arrive)) {
                    $post_depart = $db->fetch_assoc($sql_post_depart, 1);
                    $post_arrive = $db->fetch_assoc($sql_post_arrive, 1);
                    $id_depart = $post_depart['id_point'];
                    $id_arrive = $post_arrive['id_point'];

                    $sql_post_trip = "INSERT INTO trajet VALUES (
                            '',
                            '$conducteur',
                            '$id_depart',
                            '$id_arrive',
                            '$post_place',
                            '$post_date'
                    )";
                    $db->query($sql_post_trip);
                    if ($post_date_retour != '') {
                        $sql_post_trip_retour = "INSERT INTO trajet VALUES (
                                '',
                                '$conducteur', 
                                '$id_arrive',
                                '$id_depart',
                                '$post_place',
                                '$post_date_retour'
                        )";
                        $db->query($sql_post_trip_retour);
                    }
                    $db->close();
                    echo $success.'Publié avec succès.';
                    new Redirect($_DOMAIN.'mes-annonces');
                } else {
                    echo 'Address introuvable, veuillez choisir l\'autre!';
                }
            }
        }
    }
    else {
        new Redirect($_DOMAIN);
    }
}
else {
    new Redirect($_DOMAIN);
}