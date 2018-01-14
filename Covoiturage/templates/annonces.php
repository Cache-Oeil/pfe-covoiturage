<section id="annonce">
    <div class="container">
        <div class="annonce-wrapper">
            <div class="annonce-head">
                <h1 class="text-center pt-3 pb-3">MES ANNONCES</h1>
            </div>
            <div class="annonce-body">
<?php
$user_id = $data_user['id_compte'];
$sql_get_annonce = "SELECT * FROM trajet WHERE id_conducteur = '$user_id' AND date_depart >= '$date_current'";
if ($db->num_rows($sql_get_annonce)) {
    foreach ($db->fetch_assoc($sql_get_annonce, 0) as $key => $annonces) {

        $depart = $annonces['pt_depart'];
        $arrive = $annonces['pt_arrive'];
        $sql_address_depart = "SELECT * FROM point WHERE id_point = '$depart'";
        $sql_address_arrive = "SELECT * FROM point WHERE id_point = '$arrive'";
        if ($db->num_rows($sql_address_depart) && $db->num_rows($sql_address_arrive)) {
            $depart = $db->fetch_assoc($sql_address_depart, 1)['nom'];
            $arrive = $db->fetch_assoc($sql_address_arrive, 1)['nom'];
        }

        $date_depart = date_en_fr($annonces['date_depart']);
        $heure_depart = strtotime($annonces['date_depart']);
        $heure_depart = date('H', $heure_depart).'h'.date('i', $heure_depart);


        echo
        '
                <div class="card border-light mb-3" data-trajet="'.$annonces["id_trajet"].'">
                    <div class="card-header">
                        <i class="fa fa-taxi" aria-hidden="true"></i>
                        <h2 class="d-inline-block ml-2">'.(3 - $annonces["places"]).' réservation en attendant</h2>
                        <button type="button" class="close" aria-label="Close" data-toggle="modal" data-target="#deleteAnnonce">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <div class="popover-custom d-none">
                            <div class="arrow"></div>
                            <div class="popover-body">Une erreur est survenue, veuillez réessayer plus tard</div>
                        </div>
                    </div>
                    <div class="card-body text-primary">
                        <h4 class="card-title">'.$depart.' <i class="fa fa-long-arrow-right" aria-hidden="true"></i> '.$arrive.'</h4>
                        <p class="card-text mb-3">Date de départ : '.$date_depart.'</p>
                        <p class="card-text mb-3">L\'heure : '.$heure_depart.'</p>
                        <p class="mb-3">
                            <button class="btn btn-light border-info text-info" data-toggle="collapse" data-target="#collapse-'.$annonces["id_trajet"].'" aria-expanded="false" aria-controls="collapse-'.$annonces["id_trajet"].'">
                                Place réservé <i class="fa fa-chevron-down" aria-hidden="true"></i>
                            </button>
                        </p>
                        <div class="collapse" id="collapse-'.$annonces["id_trajet"].'">
                            <div class="card card-body">';
        $sql_get_reservation = "SELECT * FROM reservation WHERE id_trajet = ".$annonces["id_trajet"];
        if ($db->num_rows($sql_get_reservation)) {
            foreach ($db->fetch_assoc($sql_get_reservation, 0) as $item => $reservation) {
                $passager = $reservation['id_passager'];
                $sql_get_passager = "SELECT * FROM compte WHERE id_compte = '$passager'";
                $passager = $db->num_rows($sql_get_passager) ? $db->fetch_assoc($sql_get_passager, 1) : '';
                if ($passager == '') {
                    die('Une erreur est survenue, veuillez réessayer plus tard');
                }
                else {
                    echo
                    '           <div class="row passager-card" data-reserv="'.$reservation["id_reservation"].'">
                                    <div class="col-md-8 col-lg-9 media">
                                        <div class="middle">
                                            <img class="align-self-center mr-3" src="';
                    if ($passager['url_avatar'] == '') {
                        echo 'img/default-profile.png';
                    } else {
                        echo $passager['url_avatar'];
                    }
                    echo
                                        '" alt="photo de profile">
                                        </div>
                                        <div class="media-body middle">
                                            <h5 class="mt-0">'.$passager["prenom"].' '.$passager["nom"];
                    if ($reservation['statut'] == 0) {
                        echo '<i class="fa fa-exclamation-circle text-warning ml-1" aria-hidden="true"></i>';
                    }
                    else {
                        echo '<i class="fa fa-check-circle text-success ml-1" aria-hidden="true"></i>';
                    }
                    echo
                    '                       </h5>
                                            <p>'.$passager["username"].'</p>
                                            <p class="mb-0">'.$passager["age"].' ans</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-lg-3 text-center">';
                    if ($reservation['statut'] == 0) {
                        echo '<button class="btn btn-success btn-sm mr-sm-1 mt-1 mt-md-2 accepte">Accepter</button>';
                    } else {
                        echo '<button class="btn btn-warning btn-sm mr-sm-1 mt-1 mt-md-2 decline">Décliner</button>';
                    }
                    echo
                    '                   <button class="btn btn-danger btn-sm ml-sm-1 mt-1 mt-md-2 annulle" data-toggle="modal" data-target="#deleteReservation">Annuller</button>
                                    </div>
                                </div>
                                <div class="alert alert-danger d-none"></div>';
                }
            }
            echo '
                                <div class="modal fade" tabindex="-1" role="dialog" id="deleteReservation">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Annulation de réservation</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                  <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Voulez-vous vraiment annuller cette réservation?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary">Oui</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
            ';
        }
        echo
        '                      
                            </div>
                        </div>
                    </div>
                </div>
        ';
    }

    echo
    '
                <div class="modal fade" tabindex="-1" role="dialog" id="deleteAnnonce">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Annulation de l\'annonce</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Voulez-vous vraiment annuller cet annonce?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-primary">Oui</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
                            </div>
                        </div>
                    </div>
                </div>
    ';
} else {
    echo
    '           <div class="alert alert-warning text-center">
                    Vous n\'avez pas publié d\'annonce pour le moment.<br><br>
                    <a href="'. $_DOMAIN .'post-trip">Publiez gratuitement votre annonce !</a>
                </div>
    ';
}
?>
            </div>
        </div>
    </div>
</section>

