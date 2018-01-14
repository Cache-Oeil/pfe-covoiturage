
    <section id="finder">
        <div class="container search-bar">
            <form id="formSearchTrip2" class="live-search-form clearfix">
                <div class="field-wrap mb-3 mb-lg-0 mr-md-2 float-lg-left">
                    <button class="geolocation" id="locateUser2"><i class="fa fa-dot-circle-o" aria-hidden="true"></i></button>
                    <label class="image-replace start" for="origin_input">Adresse de départ</label>
                    <input class="full-width has-padding has-border" type="text" id="origin_input" placeholder="Adresse de départ" autocomplete="off">
                    <div class="live-search"><ul></ul></div>
                </div>
                <div class="swap-wrapper mr-2 float-lg-left d-none d-lg-block">
                    <button class="btn btn-default btn-swap"></button>
                </div>
                <div class="field-wrap mb-3 mb-lg-0 mr-md-2 float-lg-left">
                    <label class="image-replace end" for="destination_input">Adresse d'arrivé</label>
                    <input class="full-width has-padding has-border" type="text" id="destination_input" placeholder="Adresse d'arrivé" autocomplete="off">
                    <div class="live-search"><ul></ul></div>
                </div>
                <div class="date-time-picker mb-3 mb-lg-0">
                    <div class="row m-0">
                        <div class="col-7 p-0">
                            <div class="form-group mb-0">
                                <div class='input-group date'>
                                    <input type='text' class="form-control" id="date_input"/>
                                    <span class="input-group-addon">
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-5 pl-3 pl-md-2 pr-0">
                            <div class="form-group mb-0">
                                <div class='input-group time'>
                                    <input type='text' class="form-control" id="hour_input"/>
                                    <span class="input-group-addon">
                                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                                </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="submit-wrapper">
                    <button type="submit" class="btn btn-success search-submit"><span>Chercher</span></button>
                </div>
            </form>
            <div class="alert alert-danger d-none text-center mt-3"></div>
            <div id="map-2" class="mt-4 mb-2"></div>
        </div>
    </section>

    <section id="listTrip">
        <div class="container">
            <div class="row">
                <?php require_once 'sidebar.php'; ?>
                <div class="col-lg-8 list-content">
                    <div class="search-alert bg-primary">
                        <h1>Covoiturage pour </h1>
                    </div>
                    <?php require_once 'result_content.php'?>
                </div>
            </div>
        </div>
    </section>

