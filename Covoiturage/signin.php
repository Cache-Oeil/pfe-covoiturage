<?php

require_once 'core/init.php';

if (isset($_POST['user_signin']) && isset($_POST['pass_signin'])) {
    /* traiter les valeurs */
    $user_signin = trim(htmlspecialchars(addslashes($_POST['user_signin'])));
    $pass_signin = trim(htmlspecialchars(addslashes($_POST['pass_signin'])));

    // les annonces
    $show_alert = '<script>$("#cd-login .cd-form .alert").removeClass("d-none");</script>';
    $hide_alert = '<script>$("#cd-login .cd-form .alert").addClass("d-none");</script>';
    $success = '<script>$("#cd-login .cd-form .alert").attr("class", "alert alert-success");</script>';

    if ($user_signin == '' || $pass_signin == '')
    {
        echo $show_alert.'Remplissez le formulaire, s\'il vous plaît';
    }
    else
    {
        $sql_check_user_exist = "SELECT username FROM compte WHERE username = '$user_signin'";
        // Si username existe
        if ($db->num_rows($sql_check_user_exist))
        {
            $pass_signin = md5($pass_signin);
            $sql_check_signin = "SELECT username, password FROM compte WHERE username = '$user_signin' AND password = '$pass_signin'";
            if ($db->num_rows($sql_check_signin))
            {
                $sql_check_stt = "SELECT username, password, statut FROM compte WHERE username = '$user_signin' AND password = '$pass_signin' AND statut = '0'";
                // Nếu username và password khớp và tài khoản không bị khoá (status = 0)
                if ($db->num_rows($sql_check_stt))
                {
                    // Lưu session
                    $session->set($user_signin);
                    $db->close(); // Giải phóng

                    echo $show_alert.$success.'Connexion succès.';
                    new Redirect($_DOMAIN); // Trở về trang index
                }
                else
                {
                    echo $show_alert.'Votre compte a été verrouillé, veuillez contacter votre administrateur pour plus de détails.';
                }
            }
            else
            {
                echo $show_alert.'Les mots de passe sont incorrects.';
            }
        }
        // En revanche, usename n'existe pas
        else
        {
            echo $show_alert.'L\' identifiant n\'existe pas.';
        }
    }
}
// En revanche, il n'y a pas de méthode post
else
{
    new Redirect($_DOMAIN); // Trở về trang index
}
