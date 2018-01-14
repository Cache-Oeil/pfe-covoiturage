<div class="col-lg-4 d-none d-lg-block sidebar pl-0">
    <div class="sidebar-wrapper p-3">
        <h3>Heure :</h3>
        <div class="time-slider">
            <div class="range-slider mt-3 mb-4">
                <label for="time-depart">Heure de départ</label>
                <span class="float-right range-slider__value">0</span>
                <input class="float-right range-slider__range" type="range" id="time-depart" min="0" max="24" value="0">
            </div>
            <div class="range-slider mt-4 mb-4">
                <label for="time-arrive">Heure d'arrivé</label>
                <span class="float-right range-slider__value">12</span>
                <input class="float-right range-slider__range" type="range" id="time-arrive" min="0" max="24" value="12">
            </div>
        </div>
        <h3>Chauffeur :</h3>
        <div class="genre mt-2 mb-4">
            <label class="custom-control custom-radio">
                <input id="radio1" name="radio" type="radio" class="custom-control-input">
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description pt-1">Homme</span>
            </label>
            <label class="custom-control custom-radio">
                <input id="radio2" name="radio" type="radio" class="custom-control-input">
                <span class="custom-control-indicator"></span>
                <span class="custom-control-description pt-1">Femme</span>
            </label>
        </div>
        <h3>Place :</h3>
        <div class="place mt-2 mb-4">
            <select class="custom-select w-25">
                <option value="1" selected >1</option>
                <option value="2">2</option>
                <option value="3">3</option>
            </select>
        </div>
    </div>
</div>