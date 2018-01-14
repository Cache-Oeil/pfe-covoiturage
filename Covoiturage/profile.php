<?php

require_once 'core/init.php';

$index = array('prenom', 'nom', 'age', 'sexe', 'telephone', 'url_avatar', 'password');

for ($i = 0; $i < count($index); $i++ ){
    $info[$index[$i]] = isset($_POST[$index[$i]]) ? $_POST[$index[$i]] : '';
    if ($info[$index[$i]] != '') {
        $sql_update = "UPDATE compte SET ".$index[$i]." = '".$info[$index[$i]]."' WHERE id_compte = '".$data_user['id_compte']."'";
        echo $sql_update;
        $db->query($sql_update);
    }
}

$db->close();
echo '            Vous avez mis à jour avec succès
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>';
new Redirect($_DOMAIN.'profile');