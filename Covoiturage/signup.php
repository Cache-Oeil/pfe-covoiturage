<?php

require_once 'core/init.php';

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['nom']) &&
    isset($_POST['prenom']) && isset($_POST['email'])) {

    $usernameSignup = trim(addslashes(htmlspecialchars($_POST['username'])));
    $passwordSignup = trim(addslashes(htmlspecialchars($_POST['password'])));
    $nomSignup = trim(addslashes(htmlspecialchars($_POST['nom'])));
    $prenomSignup = trim(addslashes(htmlspecialchars($_POST['prenom'])));
    $emailSignup = trim(addslashes(htmlspecialchars($_POST['email'])));

    $okMessage =
        '
        <div class="alert alert-success" role="alert">
            Vous vous avez inscrit avec succès
        </div>
        ';
    $errorMessage =
        '
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Une <strong>erreur</strong> est survenue, veuillez réessayer plus tard
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        ';

    if ($usernameSignup == '' || $passwordSignup == '' || $nomSignup == '' || $prenomSignup == '' || $emailSignup == '') {
        echo $errorMessage;
    } else {
        $sql_check_username_email = "SELECT username, email FROM compte WHERE username = '$usernameSignup' OR email = '$emailSignup'";
        if ($db->num_rows($sql_check_username_email)) {
            $usernameExit = $db->fetch_assoc($sql_check_username_email, 1)['username'];
            $emailExit = $db->fetch_assoc($sql_check_username_email, 1)['email'];
            if ($usernameExit == $usernameSignup) {
                echo 'userExit';
            } else if ($emailExit == $emailSignup) {
                echo 'emailExit';
            }
        } else {
            $passwordSignup = md5($passwordSignup);
            $sql_signup = "INSERT INTO compte VALUES (
                '',
                '$nomSignup',
                '$prenomSignup',
                '$usernameSignup',
                '$passwordSignup',
                '',
                '',
                '',
                '$emailSignup',
                '',
                '$date_current',
                '0'
            )";
            $db->query($sql_signup);
            $db->close();

            echo $okMessage;
            new Redirect($_DOMAIN);
        }
    }
}
else {
    new Redirect($_DOMAIN);
}

?>