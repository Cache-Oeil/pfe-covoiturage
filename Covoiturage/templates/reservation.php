<section id="reservation">
    <div class="container">
        <div class="reservation-wrapper">
            <div class="reservation-head">
                <h1 class="text-center pt-3 pb-3">MES RESERVATION</h1>
            </div>
            <div class="reservation-body">
                <?php
                $html = '';
                $passenger = $data_user['id_compte'];
                $sql_check_reservation = "SELECT * FROM reservation WHERE id_passager = '$passenger'";

                if ($db->num_rows($sql_check_reservation)) {

                    $html .= '
                <ul class="pl-3 pr-3">';

                    foreach ($db->fetch_assoc($sql_check_reservation, 0) as $key => $reservation) {

                        $id_trajet = $reservation['id_trajet'];
                        $sql_get_trajet = "SELECT * FROM trajet WHERE id_trajet = '$id_trajet' AND date_depart >= '$date_current'";

                        if ($db->num_rows($sql_get_trajet)) {

                            $trajet = $db->fetch_assoc($sql_get_trajet, 1);
                            $conducteur = $trajet['id_conducteur'];
                            $sql_get_conducteur = "SELECT * FROM compte WHERE id_compte = '$conducteur'";

                            if ($db->num_rows($sql_get_conducteur)) {

                                $conducteur = $db->fetch_assoc($sql_get_conducteur, 1);
                                $pt_depart = $trajet['pt_depart'];
                                $pt_arrive = $trajet['pt_arrive'];

                                $sql_pt_depart = "SELECT nom FROM point WHERE id_point = '$pt_depart'";
                                $sql_pt_arrive = "SELECT nom FROM point WHERE id_point = '$pt_arrive'";

                                if ($db->num_rows($sql_pt_depart) && $db->num_rows($sql_pt_arrive)) {
                                    $pt_depart = $db->fetch_assoc($sql_pt_depart, 1)['nom'];
                                    $pt_arrive = $db->fetch_assoc($sql_pt_arrive, 1)['nom'];
                                }

                                $date_depart = strtotime($trajet['date_depart']);

                                $html .= '
                    <li class="trip mb-3">
                        <article>
                            <header class="trip-head pt-2 pt-md-3 pb-2">
                                <h2>
                                    <span><i class="fa fa-calendar-o" aria-hidden="true"></i></span>
                                    '.date_en_fr($trajet["date_depart"]).'
                                </h2>
                            </header>
                            <div class="row trip-card">
                                <div class="col-md-4 col-lg-3 profile-card media">
                                    <div class="profile-photo middle">
                                        <img src="';

                                // URL ảnh đại diện tài khoản
                                if ($conducteur['url_avatar'] == '') {
                                    $html .= $_DOMAIN . 'img/default-profile.png';
                                } else {
                                    $html .= $conducteur['url_avatar'];
                                }

                                $html .= '
                                        " alt="photo de conducteur" class="align-self-start mr-3 rounded-circle img-thumbnail">
                                    </div>
                                    <div class="profile-info media-body middle">
                                        <h3 class="profile-name mb-2">' . $conducteur["prenom"] . ' ' . $conducteur["nom"] . '</h3>
                                        <p class="profile-age">' . $conducteur["age"] . 'ans</p>
                                    </div>
                                </div>
                                <div class="col-md-6 col-lg-6 col-xl-7 info-card">
                                    <h2>';

                                $jour = date("d", $date_depart) - date("d", strtotime($date_current));
                                switch ($jour) {
                                    case 0:
                                        $html .= 'Aujourd\'hui';
                                        break;
                                    case 1:
                                        $html .= 'Demain';
                                        break;
                                    default:
                                        $html .= 'Le '.date("d/m", $date_depart);
                                        break;
                                }

                                $html .= ' à ' . date("H", $date_depart) . 'h' . date("i", $date_depart) . '
                                    </h2>
                                    <ul>
                                        <li>
                                            <i class="fa fa-map-marker text-success" aria-hidden="true"></i>' .
                                    $pt_depart . '
                                        </li>
                                        <li>
                                            <i class="fa fa-map-marker text-danger" aria-hidden="true"></i>' .
                                    $pt_arrive . '
                                        </li>
                                        <li>
                                            <i class="fa fa-users text-primary" aria-hidden="true"></i>' .
                                    $trajet["places"] . ' place disponible
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-3 col-xl-2">';

                                if ($reservation['statut'] == 0) {
                                    $html .= '<div class="alert alert-danger text-center mt-3 mb-0">Pas d\'accept</div>';
                                }
                                else {
                                    $html .= '<div class="alert alert-success text-center mt-3 mb-0">Accepté</div>';
                                }

                                $html .= '
                                    <button data-trajet="'.$id_trajet.'" data-toggle="modal" data-target="#annulReserve" class="btn btn-outline-dark w-100 mt-3">Annuller</button>
                                </div>
                            </div>
                        </article>
                        <div class="alert alert-danger alert-dismissible fade show d-none"></div>
                    </li>';
                            }
                        }
                    }
                $html .= '
                </ul>';
                }
                else {
                    $html .= '
                <div class="alert alert-warning text-center">
                    Vous n\'avez aucune réservation pour le moment.<br><br>
                    <a href="'. $_DOMAIN .'">Cherchez un covoiturage gratuitement?</a>
                </div>
                    ';
                }

                echo $html;
                ?>


                <!-- Modal -->
                <div class="modal fade" id="annulReserve" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Annullation de Réservation</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Vous voulez vraiment annuller cette réservation?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Non</button>
                                <button type="button" class="btn btn-primary">Oui</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>