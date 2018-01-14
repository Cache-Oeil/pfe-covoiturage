<?php
$date_limit = strtotime($date_current) + 30*60;
$date_limit = date("Y-m-d H:i:s", $date_limit);
$sql_del_trip = "DELETE FROM trajet WHERE date_depart < '$date_limit'";
$db->query($sql_del_trip);
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Covoiturage</title>

    <!-- Include Editor style. -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.8/summernote-bs4.css" rel="stylesheet">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href='https://fonts.googleapis.com/css?family=PT+Sans:400,700' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://s3-us-west-2.amazonaws.com/s.cdpn.io/148866/reset.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
    <link rel="stylesheet" href="<?php echo $_DOMAIN; ?>css/main.css">
    <link rel="stylesheet" href="<?php echo $_DOMAIN; ?>css/home_connect.css">
    <link rel="stylesheet" href="<?php echo $_DOMAIN; ?>css/result_recherche.css">

</head>
<body>
    <header role="banner" class="clearfix">

 <?php
    // déconnexion
    if (!$user) {
        echo
        '
        <nav class="main-nav">
            <ul>
                <!-- inser more links here -->
                <li class="d-block d-md-none"><a href="'. $_DOMAIN .'">Accueil</a></li>
                <li class="d-block d-md-none"><a href="#">About</a></li>
                <li class="d-block d-md-none"><a href="'.$_DOMAIN.'post-trip">Proposer un trajet</a></li>
                <li class="d-block d-md-none"><a href="#">Contact</a></li>
                <li><a class="cd-signin" href="#0">Se connecter</a></li>
                <li><a class="cd-signup" href="#0">S\'inscrire</a></li>
            </ul>
        </nav>
        <div class="cd-user-modal">
            <!-- this is the entire modal form, including the background -->
            <div class="cd-user-modal-container">
                <!-- this is the container wrapper -->
                <ul class="cd-switcher">
                    <li><a href="#0">Se connecter</a></li>
                    <li><a href="#0">Nouveau compte</a></li>
                </ul>
        ';
        require_once 'templates/signin.php';
        require_once 'templates/signup.php';

        echo
        '
                <div id="cd-reset-password">
                    <!-- reset password form -->
                    <p class="cd-form-message">Mot de passe oublié? S\'il vous plaît entrez votre adresse email. Vous recevrez un lien pour créer un nouveau mot de passe.</p>
        
                    <form class="cd-form">
                        <p class="fieldset">
                            <label class="image-replace cd-email" for="reset-email">E-mail</label>
                            <input class="full-width has-padding has-border" id="reset-email" type="email" placeholder="E-mail">
                            <span class="cd-error-message">Error message here!</span>
                        </p>
        
                        <p class="fieldset">
                            <input class="full-width has-padding" type="submit" value="Valider">
                        </p>
                    </form>
        
                    <p class="cd-form-bottom-message"><a href="#0">Retour à la connexion</a></p>
                </div>
                <!-- cd-reset-password -->
                <a href="#0" class="cd-close-form">Close</a>
            </div>
            <!-- cd-user-modal-container -->
        </div>
        <!-- cd-user-modal -->
        ';
    }
    // connexion
    else {
        echo
        '
        <nav class="menu-nav middle">
            <ul>
                <li><a href="'.$_DOMAIN.'">Accueil</a></li>
                <li><a href="'.$_DOMAIN.'post-trip">Proposer un trajet</a></li>
                <li><a href="#t">About</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>
        <nav class="profile-nav">
            <ul class="clearfix">
                <li>
                    <a href="#">
                        <span>'.$data_user["prenom"].' '.$data_user["nom"].'</span><img src="
                        ';
        if ($data_user['url_avatar'] == '') {
            echo $_DOMAIN.'img/default-profile.png';
        }
        else {
            echo $data_user['url_avatar'];
        }
        echo
        '               " alt="profil photo">
                    </a>
                </li>
                <li><i class="fa fa-bars" aria-hidden="true"></i></li>
            </ul>
            <div class="dropdown dropdown--userMenu">
                <nav class="user-nav clearfix">
                    <ul>
                        <li><a href="'.$_DOMAIN.'profile">Profil</a></li>
                        <li><a href="'.$_DOMAIN.'mes-annonces">Mes annonces</a></li>
                        <li><a href="'.$_DOMAIN.'mes-reservations">Mes réservations</a></li>
                        <li>
                            <a href="'.$_DOMAIN.'mes-messages/boite">Messages 
                                <span class="badge badge-pill badge-light ml-2">';

        $sql_unchecked_mail = "SELECT * FROM message WHERE recepteur = '".$data_user['id_compte']."' AND statut = '0'";
        $unchecked_mail = $db->num_rows($sql_unchecked_mail);
        echo $unchecked_mail;

        echo                   '</span>
                            </a>
                        </li>
                        <li><a href="'.$_DOMAIN.'signout.php">Se déconnecter</a></li>
                    </ul>
                </nav>
            </div>
        </nav>
        ';
    }
?>
    </header>

