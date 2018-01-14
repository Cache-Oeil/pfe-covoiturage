<section id="post">
    <div class="container">
        <div class="post-wrapper">
            <div class="post-head">
                <h1 class="text-center pt-3 pb-3">PUBLIER UN TRAJET</h1>
            </div>
            <div class="stepwizard">
                <div class="stepwizard-row setup-panel">
                    <div class="stepwizard-step w-25">
                        <a href="#step-1" type="button" class="btn btn-primary btn-circle">1</a>
                        <p class="d-none d-md-block">MON TRAJET</p>
                    </div>
                    <div class="stepwizard-step w-25">
                        <a href="#step-2" type="button" class="btn btn-dark btn-circle disabled">2</a>
                        <p class="d-none d-md-block">PLACES</p>
                    </div>
                    <div class="stepwizard-step w-25">
                        <a href="#step-3" type="button" class="btn btn-dark btn-circle disabled">3</a>
                        <p class="d-none d-md-block">DATE / HEURE</p>
                    </div>
                    <div class="stepwizard-step w-25">
                        <a href="#step-4" type="button" class="btn btn-dark btn-circle disabled">4</a>
                        <p class="d-none d-md-block">PUBLICATION</p>
                    </div>
                </div>
            </div>

            <form id="formPostTrip" method="post" class="live-search-form pt-3 pb-4">
                <div class="row justify-content-center setup-content" id="step-1">
                    <div class="col-11 col-md-8 col-lg-6">
                        <h3 class="text-center mb-2">Mon trajet</h3>
                        <div class="form-group field-wrap">
                            <label for="post_depart" class="control-label mb-2"><h4>Adresse de départ</h4></label>
                            <input id="post_depart" maxlength="100" type="text" required="required" class="form-control" placeholder="Adresse de départ" autocomplete="off"/>
                            <div class="live-search"><ul id="results"></ul></div>
                        </div>
                        <div class="form-group field-wrap">
                            <label for="post_arrive" class="control-label mb-2"><h4>Adresse d'arrivé</h4></label>
                            <input id="post_arrive" maxlength="100" type="text" required="required" class="form-control" placeholder="Adresse d'arrivé" autocomplete="off"/>
                            <div class="live-search"><ul></ul></div>
                        </div>
                        <div class="form-group">
                            <label class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input">
                                <span class="custom-control-indicator"></span>
                                <span class="custom-control-description pt-1">Aller / Retour</span>
                            </label>
                        </div>
                        <button class="btn btn-primary nextBtn btn-lg pull-right mt-3" type="button" >Suivant</button>
                    </div>
                </div>
                <div class="row justify-content-center setup-content" id="step-2">
                    <div class="col-11 col-md-8 col-lg-6">
                        <h3 class="text-center mb-2">Places disponibles</h3>
                        <div class="form-group mt-3">
                            <h4 class="d-inline-block mr-2">Nombre de places disponibles </h4>
                            <select id="post_place" class="custom-select mt-2 mt-sm-0 mb-2 mb-sm-0">
                                <option value="1" selected >1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div>
                        <div class="form-group mt-3 d-none">
                            <h4 class="d-inline-block mr-2">Nombre de places disponibles au retour </h4>
                            <select id="post_place_retour" class="custom-select mt-2 mt-sm-0 mb-2 mb-sm-0">
                                <option value="1" selected >1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                            </select>
                        </div>
                        <button class="btn btn-secondary prevBtn btn-lg pull-left mt-3" type="button" >Precedant</button>
                        <button class="btn btn-primary nextBtn btn-lg pull-right mt-3" type="button" >Suivant</button>
                    </div>
                </div>
                <div class="row justify-content-center setup-content" id="step-3">
                    <div class="col-11 col-md-8 col-lg-6">
                        <h3 class="text-center mb-2">Date / Heure</h3>
                        <div class="form-group">
                            <label class="control-label mb-2">Jour</label>
                            <div class='input-group date'>
                                <input id="post_date" type='text' class="form-control" required="required"/>
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label mb-2">Heure de départ</label>
                            <div class='input-group time'>
                                <input id="post_hour" type='text' class="form-control" required="required"/>
                                <span class="input-group-addon">
                                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group d-none">
                            <label class="control-label mb-2">Jour de retour</label>
                            <div class='input-group date'>
                                <input id="post_date_retour" type='text' class="form-control" required="required"/>
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group d-none">
                            <label class="control-label mb-2">Heure de retour</label>
                            <div class='input-group time'>
                                <input id="post_hour_retour" type='text' class="form-control" required="required"/>
                                <span class="input-group-addon">
                                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                                </span>
                            </div>
                        </div>
                        <button class="btn btn-secondary prevBtn btn-lg pull-left mt-3" type="button" >Precedant</button>
                        <button class="btn btn-primary nextBtn btn-lg pull-right mt-3" type="button">Suivant</button>
                    </div>
                </div>
                <div class="row justify-content-center setup-content" id="step-4">
                    <div class="col-11 col-md-8 col-lg-6">
                        <h3 class="text-center mb-2">Publication</h3>
                        <div class="form-group">
                            <h4 class="mb-2">Mon trajet</h4>
                            <div class="alert alert-success">
                                <span class="address-label">Départ :</span>
                                <strong><span id="submit_depart"></span></strong>
                                <br>
                                <span class="address-label">Arrivé :</span>
                                <strong><span id="submit_arrive"></span></strong>
                                <a href="#step-1" class="modify">Modifier</a>
                            </div>
                            <h4 class="mb-2">Place</h4>
                            <div class="alert alert-success">
                                <strong><span id="submit_place"></span></strong> places disponibles
                                <span class="submit-retour d-none"> au depart et <strong><span id="submit_place_retour"></span></strong> places disponibles au retour</span>
                                <a href="#step-2" class="modify">Modifier</a>
                            </div>
                            <h4 class="mb-2">Date/Heure</h4>
                            <div class="alert alert-success">
                                Départ le <strong><span id="submit_date"></span></strong> à <strong><span id="submit_hour"></span></strong>
                                <span class="submit-retour d-none"><br><br>Retour le <strong><span id="submit_date_retour"></span></strong>
                                    à <strong><span id="submit_hour_retour"></span></strong></span>
                                <a href="#step-3" class="modify">Modifier</a>
                            </div>
                        </div>
                        <button class="btn btn-secondary prevBtn btn-lg pull-left mt-3" type="button" >Precedant</button>
                        <button class="btn btn-success btn-lg pull-right mt-3" type="submit" >Valide</button>
                        <div class="alert alert-danger d-none" id="post_alert"></div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>