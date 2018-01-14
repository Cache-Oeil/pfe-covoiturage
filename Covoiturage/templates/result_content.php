<?php

//$id_result_depart = isset($_COOKIE['dep']) ? trim(addslashes(htmlspecialchars($_COOKIE['dep']))) : '';
$id_result_arrive = isset($_COOKIE['arr']) ? trim(addslashes(htmlspecialchars($_COOKIE['arr']))) : '';
$recherche_date = isset($_COOKIE['recherche_date']) ? trim(addslashes(htmlspecialchars($_COOKIE['recherche_date']))) : '';
$recherche_hour = isset($_COOKIE['recherche_hour']) ? trim(addslashes(htmlspecialchars($_COOKIE['recherche_hour']))) : '';

if ($id_result_arrive == '' /*|| $id_result_depart == ''*/) {
    echo '<div class="alert alert-danger">Une erreur est survenue, veuillez réessaiyer!</div>';
} else {

    $html = '';

    //$sql_address_depart = "SELECT * FROM point WHERE id_point = '$id_result_depart'";
    $sql_address_arrive = "SELECT * FROM point WHERE id_point = '$id_result_arrive'";

    if (/*$db->num_rows($sql_address_depart) &&*/ $db->num_rows($sql_address_arrive)) {
        //$result_depart = $db->fetch_assoc($sql_address_depart, 1)['nom'];
        //$result_depart = $id_result_depart; // dong code nay hoi ruom ra
        $result_arrive = $db->fetch_assoc($sql_address_arrive, 1)['nom'];
    }

    if ($recherche_date == '') {
        $sql_get_result = "SELECT * FROM trajet WHERE pt_arrive = '$id_result_arrive' AND date_depart >= '$date_current'";
    } else {
        if ($recherche_hour == '') {
            $sql_get_result = "SELECT * FROM trajet WHERE pt_arrive = '$id_result_arrive' AND date_depart >= '$recherche_date'";
        } else {
            $recherche_date_hour = date("Y-m-d H:i:s", strtotime($recherche_date.' '.$recherche_hour));
            $sql_get_result = "SELECT * FROM trajet WHERE pt_arrive = '$id_result_arrive' AND date_depart >= '$recherche_date_hour'";
        }
    }


    if ($db->num_rows($sql_get_result)) {
        $html .=
        '
        <div class="search-result">
            <ul class="trip-search-result">
        ';
        foreach ($db->fetch_assoc($sql_get_result, 0) as $key => $trajet_publie) {
            $id_trajet = $trajet_publie['id_trajet'];
            $conducteur = $trajet_publie['id_conducteur'];
            $sql_address_depart = "SELECT * FROM point WHERE id_point = '".$trajet_publie['pt_depart']."'";
            $sql_get_conducteur = "SELECT * FROM compte WHERE id_compte = '$conducteur'";
            $sql_orig = "SELECT * FROM point WHERE id_point = '".$trajet_publie['pt_depart']."'";
            $sql_dest = "SELECT * FROM point WHERE id_point = '".$trajet_publie['pt_arrive']."'";
            if ($db->num_rows($sql_get_conducteur) && $db->num_rows($sql_orig) && $db->num_rows($sql_dest) &&
                $db->num_rows($sql_address_depart)) {
                $conducteur = $db->fetch_assoc($sql_get_conducteur, 1);
                $result_depart = $db->fetch_assoc($sql_address_depart, 1)['adresse'];
                $orig_lat = $db->fetch_assoc($sql_orig, 1)['lat'];
                $orig_lng = $db->fetch_assoc($sql_orig, 1)['lng'];
                $dest_lat = $db->fetch_assoc($sql_dest, 1)['lat'];
                $dest_lng = $db->fetch_assoc($sql_dest, 1)['lng'];

                $html .=
                '
                <li class="trip mb-3" data-origlatlng=\'{"lat":'.$orig_lat.', "lng": '.$orig_lng.'}\' data-destlatlng=\'{"lat":'.$dest_lat.', "lng": '.$dest_lng.'}\'>
                    <article>
                        <header class="trip-head pt-2 pt-md-3 pb-2">
                            <h2>
                                <span><i class="fa fa-calendar-o" aria-hidden="true"></i></span>
                                '.date_en_fr($trajet_publie["date_depart"]).'
                                </h2>
                        </header>
                        <div class="row trip-card">
                            <div class="col-md-4 col-lg-3 profile-card media">
                                <div class="profile-photo middle">
                                    <img src="            
                ';
                // URL ảnh đại diện tài khoản
                if ($conducteur['url_avatar'] == '') {
                    $html .= $_DOMAIN . 'img/default-profile.png';
                } else {
                    $html .= $conducteur['url_avatar'];
                }

                $html .=
                '
                " alt="photo de conducteur" class="align-self-start mr-3 rounded-circle img-thumbnail">
                                </div>
                                <div class="profile-info media-body middle">
                                    <h3 class="profile-name mb-2">' . $conducteur["prenom"] . ' ' . $conducteur["nom"] . '</h3>
                                    <p class="profile-age">' . $conducteur["age"] . 'ans</p>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xl-7 info-card">
                                <h2>    
                ';
                $jour = date("d", strtotime($trajet_publie['date_depart'])) - date("d", strtotime($date_current));
                switch ($jour) {
                    case 0:
                        $html .= 'Aujourd\'hui';
                        break;
                    case 1:
                        $html .= 'Demain';
                        break;
                    default:
                        $html .= 'Le '.date("d/m", strtotime($trajet_publie['date_depart']));
                        break;
                }
                $heure_depart = strtotime($trajet_publie['date_depart']);
                $html .= ' à ' . date("H", $heure_depart) . 'h' . date("i", $heure_depart) . '
                                </h2>
                                <ul>
                                    <li>
                                        <i class="fa fa-map-marker text-success" aria-hidden="true"></i>' .
                    $result_depart . '
                                    </li>
                                    <li>
                                        <i class="fa fa-map-marker text-danger" aria-hidden="true"></i>' .
                    $result_arrive . '
                                    </li>
                                    <li>
                                        <i class="fa fa-users text-primary" aria-hidden="true"></i>' .
                    $trajet_publie["places"] . ' place disponible
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-2 col-lg-3 col-xl-2">
                                <button data-target="#contact" data-toggle="modal" class="btn btn-outline-dark w-100 mt-3"';
                if ($trajet_publie['id_conducteur'] === $data_user['id_compte']) {
                    $html .= ' disabled';
                }
                $html .=        '>Contactez</button>
                                <a tabindex="0" role="button" data-toggle="popover" data-trigger="focus" data-trajet="'.$id_trajet.'" class="btn btn-outline-dark w-100 mt-3 reserve';

                if ($trajet_publie['id_conducteur'] === $data_user['id_compte'] || $trajet_publie['places'] == 0) {
                    $html .= ' disabled" aria-disabled="true';
                }
                $html .=        '">Réserver</a>
                            </div>
                        </div>
                    </article>
                    <div class="message"></div>
                </li>
                ';
            }
        }
        $html .=
        '    </ul>
        </div>';
        $db->close();
        echo $html;
    }

}
?>
<!-- Modal -->
<div class="modal fade" id="contact" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Contact</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-light border-secondary">À : Remz</div>
                <div class="alert alert-light border-secondary">Tél: 01212121</div>
                <div id="summernote"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuller</button>
                <button type="button" class="btn btn-primary">Envoyer</button>
            </div>
        </div>
    </div>
</div>
