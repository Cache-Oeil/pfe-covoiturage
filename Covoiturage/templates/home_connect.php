<section id="search-trip">
    <div class="container">
        <div class="search-trip-wrapper">
            <div class="jumbotron">
                <h1 class="text-center">
                    <span class="line-1">Partagez votre voiture</span>
                    <span class="line-2">Trouvez un covoiturage</span>
                </h1>
            </div>
            <div class="search-bar">
                <form method="POST" onsubmit="return false" class="live-search-form" id="formSearchTrip">
                    <fieldset class="clearfix">
                        <div class="origin field-wrap">
                            <button class="geolocation"><i class="fa fa-dot-circle-o" aria-hidden="true"></i></button>
                            <label class="image-replace start" for="start_Address">Adresse de départ</label>
                            <input class="full-width has-padding has-border" type="text" id="start_Address" placeholder="Adresse de départ" autocomplete="off">
                            <div class="live-search"><ul></ul></div>
                        </div>
                        <div class="destination field-wrap">
                            <label class="image-replace end" for="end_Address">Adresse d'arrivé</label>
                            <input class="full-width has-padding has-border" type="text" id="end_Address" placeholder="Adresse d'arrivé" autocomplete="off">
                            <div class="live-search"><ul></ul></div>
                        </div>
                        <div class="submit-wrapper text-center">
                            <button type="submit" class="btn btn-danger search-submit">
                                <span>Lancer ma recherche</span>
                            </button>
                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="alert alert-danger d-none text-center"></div>
            <div id="map"></div>
            <button class="grid-map btn btn-dark">Grid</button>
        </div><!-- search-trip-wrapper -->
    </div><!-- container -->
</section>
<section id="create-trip">
    <div class="teaser">
        <h2>Vous avez une voiture ?</h2>
    </div>
    <a href="<?php echo $_DOMAIN.'post-trip'; ?>" class="btn btn-success">Proposer des trajets</a>
</section>

