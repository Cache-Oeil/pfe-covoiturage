<?php

if (isset($_GET['id_message'])) {
    $id_message = trim(addslashes(htmlspecialchars($_GET['id_message'])));

    $sql_read_message = "SELECT * FROM message WHERE id_message = '$id_message'";
    if ($db->num_rows($sql_read_message)) {
        $expediteur = $db->fetch_assoc($sql_read_message, 1)['emetteur'];
        $texte = $db->fetch_assoc($sql_read_message, 1)['texte'];
        $date_envoye = $db->fetch_assoc($sql_read_message, 1)['date_envoye'];
        $statut = $db->fetch_assoc($sql_read_message, 1)['statut'];

        if ($statut == 0) {
            $sql_update_statut = "UPDATE message SET statut = 1 WHERE id_message = '$id_message'";
            $db->query($sql_update_statut);
        }

        $sql_get_nom_expediteur = "SELECT * FROM compte WHERE id_compte = '$expediteur'";
        if ($db->num_rows($sql_get_nom_expediteur)) {
            $nom_expediteur = $db->fetch_assoc($sql_get_nom_expediteur, 1)['nom'];
            $prenom_expediteur = $db->fetch_assoc($sql_get_nom_expediteur, 1)['prenom'];
        }
        $html = '
        <section id="read-message">
            <div class="container">
                <div class="message-head">
                    <a href="'.$_DOMAIN.'mes-messages/boite" class="message-back">
                        <i class="fa fa-chevron-left" aria-hidden="true"></i>
                        <span class="d-none d-md-inline-block">Boîte</span>
                    </a>
                    <h1 class="message-head-title">Message</h1>
                </div>
                <div class="message-body">
                    <div class="container">
                        <div class="lettre-head">
                            <strong>Expéditeur : </strong><span>'.$prenom_expediteur.' '.$nom_expediteur.'</span>
                            <div>'.date_en_fr($date_envoye).'</div>
                        </div>
                        <div class="lettre-content">
                            '.htmlspecialchars_decode($texte).'
                        </div>
                    </div>
                </div>
        ';




            $html .= '
            </div>
        </section>
        ';
        echo $html;
    }
}
else {
?>
<section id="message">
    <div class="container">
        <div class="message-head">
            <a href="<?php echo $_DOMAIN; ?>mes-messages/nouveau-message" class="btn btn-primary w-100">Nouveau message</a>
        </div>
        <h1 class="message-title">La boîte mail</h1>
        <div class="message-body">
            <?php
            require_once 'classes/Pagination.php';

            $html = '';
            $recepteur = $data_user['id_compte'];
            $sql_get_message = "SELECT * FROM message WHERE recepteur = '$recepteur' ORDER BY date_envoye DESC";
            $totalMessage = $db->num_rows($sql_get_message);
            if ($totalMessage) {
                $limit = 8;
                $config = [
                    'total' => $totalMessage,
                    'limit' => $limit,
                    'full' => false,
                    'querystring' => 'page'
                ];
                $page = new Pagination($config);
                $totalPage = $page->getTotalPage();
                $currentPage = $page->getCurrentPage();
                $start = ($currentPage - 1) * $limit;
                $end = $currentPage * $limit - 1;

                $message_sur_page = array_slice($db->fetch_assoc($sql_get_message, 0), $start, $limit);
                foreach ($message_sur_page as $key => $message) {
                    $emetteur = $message['emetteur'];
                    $texte = strip_tags(htmlspecialchars_decode($message['texte']));    // xoa cac tag html sau khi decode
                    if (strlen($texte) > 50) {
                        $texte = explode("\n", wordwrap($texte, 50));
                        $texte = $texte[0] . '...';
                    }
                    $date_envoye = $message['date_envoye'];

                    $sql_get_nom_emetteur = "SELECT * FROM compte WHERE id_compte = '$emetteur'";
                    if ($db->num_rows($sql_get_nom_emetteur)) {
                        $nom_emetteur = $db->fetch_assoc($sql_get_nom_emetteur, 1)['nom'];
                        $prenom_emetteur = $db->fetch_assoc($sql_get_nom_emetteur, 1)['prenom'];
                        $url_avatar = $db->fetch_assoc($sql_get_nom_emetteur, 1)['url_avatar'];

                        $html .= '
                <a href="' . $_DOMAIN . 'mes-messages/boite/' . $message["id_message"] . '" class="message-list';

                        if ($message['statut'] == 0) {
                            $html .= '';
                        } else {
                            $html .= ' r';  // class danh dau la da doc mail
                        }

                        $html .= '">
                    <div class="message-list-hd">
                        <img src="';

                        if ($url_avatar == '') {
                            $html .= $_DOMAIN . 'img/default-profile.png';
                        } else {
                            $html .= $url_avatar;
                        }

                        $html .= '" alt="photo du profil">
                    </div>
                    <div class="message-list-bd">
                        <h4>' . $prenom_emetteur . ' ' . $nom_emetteur . '</h4>
                        <small>
                            <time class="timeago" datetime="' . $date_envoye . '">';

                        if (date("Y-m-d", strtotime($date_envoye)) == date("Y-m-d", strtotime($date_current))) {
                            $html .= date("H:i", strtotime($date_envoye));
                        } else {
                            $html .= day_month_en_fr_($date_envoye);
                        }
                        $html .= '</time>
                        </small>
                        <div>' . $texte . '</div>
                    </div>
                </a>        
                        ';
                    }
                }
                echo $html;

            ?>

        </div>
        <div class="message-footer">
            <?php
            echo $page->getPagination();
            }
            ?>
        </div>
    </div>
</section>
<?php
}

?>

