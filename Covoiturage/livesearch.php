<?php

require_once 'core/init.php';

if (isset($_GET['location_value']) && !empty($_GET['location_value'])) {
    $hint = '';

    $location_value = trim(htmlspecialchars(addslashes($_GET['location_value'])));

    $sql_get_location = "SELECT nom, id_point FROM point WHERE id_point BETWEEN 1 AND 5";

    if ($db->num_rows($sql_get_location)) {
        foreach ($db->fetch_assoc($sql_get_location, 0) as $rows) {
            if (stristr($rows["nom"], $location_value)) {
                $hint .= '<li>';
                $hint .= $rows["nom"];
                $hint .= '</li>';
            }
        }
    }

    echo $hint;
}