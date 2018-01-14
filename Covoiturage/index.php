<?php

require_once 'core/init.php';
// Lay tham so rubrique
$rub = isset($_GET['rub']) ? trim(htmlspecialchars(addslashes($_GET['rub']))) : '';
// require header
require_once 'includes/header.php';

/* utilisateur */
if ($user) {
    if ($rub != '') {
        if ($rub == 'profile') {
            // load template profile
            require_once 'templates/profile.php';

        } else if ($rub == 'recherche-trip') {
            // load template tim kiem chuyen di
            require_once 'templates/recherche_trip.php';

        } else if ($rub == 'post-trip') {
            // load template tao chuyen di moi
            require_once 'templates/post_trip.php';

        } else if ($rub == 'mes-annonces') {
            // load template thong bao nhung chuyen di da tao
            require_once 'templates/annonces.php';

        } else if ($rub == 'mes-reservations') {
            // load template dat cho
            require_once 'templates/reservation.php';

        } else if ($rub == 'mes-messages') {
            // Xem danh sach tin nhan hoac soan tin nhan moi
            if (isset($_GET['type'])) {
                // Xem danh sach
                if ($_GET['type'] == 'boite') {
                    // load template hop thu
                    require_once 'templates/message.php';
                }
                // soan tin nhan moi
                else if ($_GET['type'] == 'nouveau-message') {
                    // load template soan tin nhan
                    require_once 'templates/new_message.php';
                }
            } else {
                require_once 'templates/404.php';
            }

        } else {
            require_once 'templates/404.php';
        }
    }
    else {
        require_once 'templates/home_connect.php';
    }
}
/* pas d'utilisateur */
else {
    if ($rub != '') {
        if ($rub == 'recherche-trip' || $rub == 'post-trip') {
            new Redirect($_DOMAIN);
        } else {
            require_once 'templates/404.php';
        }
    }
    else {
        require_once 'templates/home_non_connect.php';
    }
    require_once 'templates/signin.php';

}

// require footer
require_once 'includes/footer.php';

?>