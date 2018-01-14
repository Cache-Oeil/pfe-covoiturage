<?php

    require_once 'core/init.php';

    if (isset($_POST['depart']) && isset($_POST['arrive'])) {

        $point_depart = trim(htmlspecialchars(addslashes($_POST['depart'])));
        $point_arrive = trim(htmlspecialchars(addslashes($_POST['arrive'])));

        if ($point_depart == '' || $point_arrive == '') {
            echo 'error';
        }

        else {

            if (isset($_POST['date_depart']) && isset($_POST['hour_depart'])) {

                $date_depart = trim(htmlspecialchars(addslashes($_POST['date_depart'])));
                $hour_depart = trim(htmlspecialchars(addslashes($_POST['hour_depart'])));

                if ($date_depart != '') {
                    setcookie("recherche_date", $date_depart, time() + 60);
                    if ($hour_depart != '') {
                        setcookie("recherche_hour", $hour_depart, time() + 60);
                    }
                }
            }
            //$sql_get_point_depart = "SELECT * FROM point WHERE nom = '$point_depart'";

            //if ($db->num_rows($sql_get_point_depart)) {

                //$id_point_depart = $db->fetch_assoc($sql_get_point_depart, 1)['id_point'];

                $sql_get_point_arrive = "SELECT * FROM point WHERE nom = '$point_arrive'";

                if ($db->num_rows($sql_get_point_arrive)) {
                    //echo 'success';
                    $id_point_arrive = $db->fetch_assoc($sql_get_point_arrive, 1)['id_point'];

                    //setcookie("dep", $point_depart, time() + 3600);
                    setcookie("arr", $id_point_arrive, time() + 60);
                    new Redirect($_DOMAIN.'recherche-trip');
                }

                else {

                    echo 'error'; // Thong bao loi dia chi den

                }
            /*
            }

            else {

                echo '2'; // Thong bao loi dia chi xuat phat

            }*/

        }

    }

?>