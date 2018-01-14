<section id="new-message">
    <div class="container">
        <div class="message-head">
            <a href="<?php echo $_DOMAIN; ?>mes-messages/boite" class="message-back">
                <i class="fa fa-chevron-left" aria-hidden="true"></i>
                <span class="d-none d-md-inline-block">Boîte</span>
            </a>
            <h1 class="message-head-title">Envoyer nouveau message</h1>
        </div>
        <div class="message-title">Veuillez entrer les informations ci-dessous</div>
        <div class="message-body">
            <form onsubmit="return false;" id="formSendMessage">
                <div class="form-group mt-3">
                    <input type="text" class="form-control" id="recipient_username" placeholder="Le destinaire" autocomplete="off">
                    <div class="invalid-feedback">
                        Veuillez compléter ce champ
                    </div>
                </div>
                <div class="form-group">
                    <textarea class="form-control" id="message_texte" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary w-100">Envoyer</button>
                </div>
                <div class="alert d-none"></div>
                <div class="alert alert-dismissible alert-warning fade show d-none" role="alert">
                    Veuillez rédiger avant vous envoyez le message
                    <button type="button" class="close pt-2" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </form>
        </div>
        <div class="message-footer">

        </div>
    </div>
</section>