<section id="profile">
    <div class="container">
        <div class="profile-head">
            <h1><i class="fa fa-th-large mr-1 ml-1" aria-hidden="true"></i> COMPTE D'UTILISATEUR</h1>
        </div><!-- profile head -->

        <div class="row">
            <!-- left column -->
            <div class="col-md-3">
                <div class="text-center">
                    <img src="
                    <?php
                    if ($data_user['url_avatar'] == '') {
                        echo 'img/default-profile.png';
                    }
                    else {
                        echo $data_user['url_avatar'];
                    }
                    ?>
                    " class="avatar rounded-circle" alt="avatar" width="100" height="100">
                </div>
                <hr class="cutline d-none d-md-block">
                <div class="profile-detail d-none d-md-block">
                    <span class="p-nom"><?php echo $data_user['prenom'].' '.$data_user['nom']; ?></span>
                    <span class="p-role"><i class="fa fa-user-o" aria-hidden="true"></i> Membre</span>
                    <span class="p-age"><i class="fa fa-calendar" aria-hidden="true"></i> <?php echo $data_user['age']; ?> ans</span>
                    <span class="p-genre"><i class="fa fa-mars" aria-hidden="true"></i> <?php echo ucfirst($data_user['sexe']); ?></span>
                    <span class="p-email"><i class="fa fa-paper-plane-o" aria-hidden="true"></i> <?php echo $data_user['email']; ?></span>
                </div>
            </div>

            <!-- edit form column -->
            <div class="col-md-9 personal-info">
                <div class="personal-info-header">
                    <h3>Personal info</h3>
                </div>
                <div class="personal-info-content">
                    <div class="alert alert-info alert-dismissable d-none">
                        <a class="panel-close close" data-dismiss="alert">×</a>
                        <i class="fa fa-coffee"></i>
                        This is an <strong>.alert</strong>. Use this to show important messages to the user.
                    </div>


                    <form id="formUpdateProfile">
                        <div class="form-group">
                            <label class="control-label">Prénom</label>
                            <div class="col-6">
                                <input class="form-control" type="text" id="update_prenom">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Nom</label>
                            <div class="col-6">
                                <input class="form-control" type="text" id="update_nom">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Âge</label>
                            <div class="col-1">
                                <input class="form-control" type="text" id="update_age">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label mt-1">Genre</label>
                            <label class="custom-control custom-radio ml-3">
                                <input name="radio" type="radio" class="custom-control-input" value="homme">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description pt-1">Homme</span>
                            </label>
                            <label class="custom-control custom-radio ml-3">
                                <input name="radio" type="radio" class="custom-control-input" value="femme">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description pt-1">Femme</span>
                            </label>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Numéro du téléphone</label>
                            <div class="col-6">
                                <input class="form-control" type="text" id="update_telephone">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Email</label>
                            <div class="col-6">
                                <input class="form-control" type="text" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">URL de photo de profil</label>
                            <div class="col-6">
                                <input class="form-control" type="text" id="update_avatar">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Pseunom</label>
                            <div class="col-6">
                                <input class="form-control" value="Cache-oeil" type="text" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Mot de passe</label>
                            <div class="col-6">
                                <input class="form-control" type="password" id="update_password">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label mt-0 mt-lg-2">Confirmez le mot de passe</label>
                            <div class="col-6">
                                <input class="form-control" type="password" id="confirm_password">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button class="btn btn-primary save">Sauvegarder</button>
                            <button class="btn btn-default">Annuler</button>
                        </div>
                        <div class="text-center d-none">
                            <div class="alert alert-success alert-dismissible fade show"></div>
                        </div>
                    </form>
                </div>
            </div>
        </div><!-- row -->
    </div><!-- container -->
    <hr>
</section>