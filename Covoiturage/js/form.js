var $_DOMAIN = 'http://localhost/Covoiturage/',
    errorMessage = "Une erreur est survenue, veuillez réessayer plus tard";

// form login
$('#cd-login .cd-form input[type="submit"]').click(function(event) {
    event.preventDefault();
    var $this = $(this);
    $this.val('Chargement en cours');

    var $username = $('#cd-login .cd-form #signin-user').val();
    var $password = $('#cd-login .cd-form #signin-password').val();

    if ($username == '') {
        $('#cd-login .cd-form #signin-user')
            .addClass('has-error')
            .next('span')
            .addClass('is-visible')
            .text('Username is empty!');
        $this.val('Me connecter');
    }
    if ($password == '') {
        $('#cd-login .cd-form #signin-password')
            .addClass('has-error')
            .next('span')
            .addClass('is-visible')
            .text('Please enter your password!');
        $this.val('Me connecter');
    }
    if ($username != '' && $password != '') {
        $.ajax({
            url : $_DOMAIN + 'signin.php',
            type : 'POST',
            data : {
                user_signin : $username,
                pass_signin : $password
            }, success : function(data) {
                $('#cd-login .cd-form .alert').removeClass('d-none');
                $('#cd-login .cd-form .alert').html(data);
                $this.val('Me connecter');
            }, error : function() {
                $('#cd-login .cd-form .alert').removeClass('d-none');
                $('#cd-login .cd-form .alert').html('Can not sign in, please try it later! ');
                $this.val('Me connecter');
            }
        });
    }
});

// form sign up
$('#cd-signup .cd-form input[type="submit"]').on('click', function(event) {
    event.preventDefault();
    var $this = $(this);

    var $username_signup = $('#signup-username').val(),
        $password_signup = $('#signup-password').val(),
        $email_signup = $('#signup-email').val(),
        $nom = $('#signup-nom').val(),
        $prenom = $('#signup-prenom').val();

    var $inscription = {
        username: $username_signup,
        password: $password_signup,
        nom : $nom,
        prenom : $prenom,
        email: $email_signup
    };

    for (var i in $inscription) {
        if ($inscription[i] == '') {
            $('#cd-signup .cd-form #signup-' + i)
                .addClass('has-error')
                .next('span').addClass('is-visible')
                .html('Veuillez remplir ce champ');
        }
    }

    var alert = '<div class="alert alert-danger">';

    if ($('#accept-terms').prop('checked') === false) {
        $('#cd-signup .cd-form .message').html(alert + 'Veuillez accepter les conditions!' + '</div>');
    } else if ($username_signup != '' && $password_signup != '' && $email_signup != '' &&
        $nom != '' && $prenom != '') {
        $.ajax({
            url : $_DOMAIN + 'signup.php',
            type : 'POST',
            data : {
                username: $username_signup,
                password: $password_signup,
                nom : $nom,
                prenom : $prenom,
                email: $email_signup
            },
            success : function(data) {
                if (data === 'userExit') {
                    console.log('fd');
                    $('#cd-signup .cd-form .message').html(alert + "L'identifiant existe déjà" + "</div>");
                } else if (data === 'emailExit') {
                    $('#cd-signup .cd-form .message').html(alert + "Email a été utilisé" + "</div>");
                } else {
                    $('#cd-signup .cd-form .message').html(data);
                }
            }, error : function() {
                $this.find('.message').html('loi');
            }
        });
    }

});

// form search trip 1
$('#formSearchTrip .search-submit').on('click', function() {

    var $alert = $('#formSearchTrip').parent().next();

    var $point_depart = $('#formSearchTrip #start_Address').val(),
        $point_arrive = $('#formSearchTrip #end_Address').val();

    if ($point_depart == '' || $point_arrive == '') {
        $alert.removeClass('d-none');
        $alert.html('Recherche impossible. Vous devez saisir et sélectionner dans la liste proposée au moins une point de départ ou d’arrivée.');
    } else {
        $.ajax({
            url: $_DOMAIN + 'recherche_trip.php',
            type: 'POST',
            data: {
                depart: $point_depart,
                arrive: $point_arrive,
            }, success: function(data) {
                /*if (data == 2) {
                    $('#formSearchTrip #start_Address').addClass('error');
                } else*/ if (data == 'error') {
                    $('#formSearchTrip #end_Address').addClass('error');
                } else {
                    $alert.html(data);
                }
            }
            , error: function() {
                $alert.removeClass('d-none');
                $alert.text('Une erreur est survenue, veuillez réessayez plus tard!');
            }
        });
    }
});

// form search trip 2
$('#formSearchTrip2 .search-submit').on('click', function(event) {
    event.preventDefault();
    var $alert = $('#formSearchTrip2').next();

    var $point_depart = $('#formSearchTrip2 #origin_input').val(),
        $point_arrive = $('#formSearchTrip2 #destination_input').val(),
        $date_depart = $('#formSearchTrip2 #date_input').val(),
        $hour_depart = $('#formSearchTrip2 #hour_input').val();

    if ($point_depart == '' || $point_arrive == '') {
        $alert.removeClass('d-none');
        $alert.html('Recherche impossible. Vous devez saisir et sélectionner dans la liste proposée au moins une point de départ ou d’arrivée.');
    } else {
        $.ajax({
            url: $_DOMAIN + 'recherche_trip.php',
            type: 'POST',
            data: {
                depart: $point_depart,
                arrive: $point_arrive,
                date_depart: $date_depart,
                hour_depart: $hour_depart
            }, success: function(data) {
                /*if (data == 2) {
                    $('#formSearchTrip #start_Address').addClass('error');
                } else*/ if (data == 'error') {
                    $('#formSearchTrip2 #destination_input').addClass('error');
                } else {
                    $alert.html(data);
                }
            }
            , error: function() {
                $alert.removeClass('d-none');
                $alert.text('Une erreur est survenue, veuillez réessayez plus tard!');
            }
        });
    }
});

// form post trip
$('#formPostTrip')
    .on('submit', function() {
        return false;
    })
    .on('click', 'button[type="submit"]', function() {
    var $depart_post_trip = $('#formPostTrip #post_depart').val(),
        $arrive_post_trip = $('#formPostTrip #post_arrive').val(),
        $place_post_trip = $('#formPostTrip #post_place').val(),
        $place_retour_post_trip = $('#formPostTrip #post_place_retour').val(),
        $date_post_trip = $('#formPostTrip #post_date').val(),
        $hour_post_trip = $('#formPostTrip #post_hour').val(),
        $date_retour_post_trip = $('#formPostTrip #post_date_retour').val(),
        $hour_retour_post_trip = $('#formPostTrip #post_hour_retour').val();

    var departLat = $('#formPostTrip #post_depart').data("lat");
    var departLng = $('#formPostTrip #post_depart').data("lng");

    if ($depart_post_trip == '' || $arrive_post_trip == '' || $place_post_trip == ''
        || $date_post_trip == '' || $hour_post_trip =='') {
        $('#formPostTrip .alert').removeClass('d-none');
        $('#formPostTrip .alert').html('Impossible de validé. Veuillez remplir les informations encore une fois, s\'il vous plaît!');
    } else {

        $date_post_trip = $date_post_trip + ' ' + $hour_post_trip;
        $date_retour_post_trip = $date_retour_post_trip + ' ' + $hour_retour_post_trip;

        $.ajax({
            url: $_DOMAIN + 'post_trip.php',
            type: 'POST',
            data: {
                depart_post_trip : $depart_post_trip,
                depart_lat : departLat,
                depart_lng : departLng,
                arrive_post_trip : $arrive_post_trip,
                place_post_trip : $place_post_trip,
                place_retour_post_trip : $place_retour_post_trip,
                date_post_trip : $date_post_trip,
                date_retour_post_trip : $date_retour_post_trip
            },
            success: function(data) {
                $('#formPostTrip #post_alert').removeClass('d-none');
                $('#formPostTrip #post_alert').html(data);
            },
            error: function() {

            }
        })
    }
})

/*
 * delete post trip
 * ~/mes-annonces
 */
$('#annonce .card-header button.close').on('click', function() {
    var $card = $('#annonce .card');
    $card.removeClass('selected');
    $(this).closest('.card').addClass('selected');
});

$('#annonce #deleteAnnonce .modal-footer button:first-child').on('click', function() {

    var $id_trajet = $('#annonce .card.selected').data("trajet");

    $.ajax({
        url: $_DOMAIN + 'delete_annonce.php',
        type: 'POST',
        data: {
            id_trajet: $id_trajet
        },
        success: function(data) {
            if (data == 'error') {
                $('#annonce .card.selected .card-header .popover-custom').removeClass('d-none');
                $('#annonce #deleteAnnonce').modal('hide');
            } else {
                $('#annonce .card.selected').addClass('d-none');
                $('#annonce #deleteAnnonce').modal('hide');
            }
        }
    })
});

/*
 * Réservation
 */
$('#listTrip a.reserve').on('click', function() {
    var $this = $(this),
        $message = $this.parent().parent().parent().next();

    var $id_trajet = $this.attr("data-trajet"),
        errorMessage = "Une erreur est survenue, veuillez réessayer plus tard",
        warningMessage = "Vous avez déjà réservé";

    if ($id_trajet == '') {
        $this.popover({content: errorMessage});
    } else {
        $.ajax({
            url: $_DOMAIN + 'reservation-controller.php',
            type: 'POST',
            data: {trajet: $id_trajet},
            success: function(data) {
                if (data == 'danger') {
                    $this.popover({content: errorMessagee});
                } else if (data == 'warning') {
                    $this.popover({content: warningMessage});
                } else {
                    $message.html(data);
                }
            },
            error: function() {
                $this.popover({content: errorMessage});
            }
        })
    }
});

/*
 * Supprimer la réservation
 * ~/mes-reservation
 */
$('#reservation .reservation-body .trip button').on('click', function() {
    $('#reservation .trip').removeClass('selected');
    $(this).closest('.trip').addClass('selected');
});
$('#reservation #annulReserve .modal-footer button:last-child').on('click', function() {

    var $id_trajet = $('#reservation .trip.selected button').data("trajet"),
        $errorMessage = "Une erreur est survenue, veuillez réessayer plus tard";

    $.ajax({
        url: $_DOMAIN + 'cancel_reservation.php',
        type: 'POST',
        data: {
            id_trajet: $id_trajet
        },
        success: function(data) {
            if(data == 'error') {
                $('#reservation .trip.selected').children('.alert').removeClass('d-none');
                $('#reservation .trip.selected').children('.alert').html($errorMessage);
            } else {
                $('#reservation .trip.selected').addClass('d-none');
                $('#reservation #annulReserve').modal('hide');
            }
        }
    });
});

/*
 * Form send message
 */
$('#formSendMessage button[type="submit"]').on('click', function(event) {
    event.preventDefault(); // eviter de valider formulaire
    var $this =$(this);

    var $recepteur = $('#formSendMessage #recipient_username').val(),
        $texte = $('#formSendMessage .note-editable').html();

    if ($recepteur == '')
        $('#formSendMessage #recipient_username').addClass("is-invalid");
    else if ($texte == '') {
        $("#formSendMessage .alert-dismissible").removeClass("d-none");
    }
    else
        $.ajax({
            url: $_DOMAIN + 'message-controller.php',
            type: 'POST',
            data: {
                recepteur: $recepteur,
                texte : $texte
            },
            success: function(data) {
                if (data == 'error') {
                    $this.parent().next('.alert').removeClass('d-none');
                    $this.parent().next('.alert').html(errorMessage);
                } else {
                    $this.parent().next('.alert').removeClass('d-none').addClass('alert-success');
                    $this.parent().next('.alert').html('Votre message a été envoyé' + data);
                }
            }
        });
});

/*
 * Toggle accepte et decline reservation dans la section Annonce
 */
$('#annonce [id|=collapse] button:first-child').on('click', function() {
    var $passager_card = $(this).closest('.passager-card'),
        action = $(this).text(),
        statut = 0;

    $id_reservation = $passager_card.data("reserv");

    if (action == 'Accepter') {
        $passager_card.find('.media-body h5 .fa')
            .removeClass('fa-exclamation-circle')
            .addClass('fa-check-circle')
            .removeClass('text-warning')
            .addClass('text-success');

        $(this)
            .removeClass('btn-success').addClass('btn-warning')
            .html('Décliner');

        statut = 1;

    } else if (action == 'Décliner'){
        $passager_card.find('.media-body h5 .fa')
            .removeClass('fa-check-circle')
            .addClass('fa-exclamation-circle')
            .removeClass('text-success')
            .addClass('text-warning');

        $(this)
            .removeClass('btn-warning').addClass('btn-success')
            .html('Accepter');
    }

    $.ajax({
        url: $_DOMAIN + 'reservation-controller.php',
        type: 'POST',
        data: {
            id_reservation: $id_reservation,
            statut: statut
        },
        success: function (data) {
            if (data == 'error') {
                $passager_card.next('.alert').removeClass('d-none').html(errorMessage);
            }
        },
        error: function () {
            $passager_card.next('.alert').removeClass('d-none').html(errorMessage);
        }
    });
});

/*
 * Supprimer la réservation dans la section Annonce
 */
$('#annonce [id|="collapse"] button:last-child').on('click', function () {
    $('#annonce .passager-card').removeClass('selected');
    $(this).closest('.passager-card').addClass('selected');
});
$('#annonce #deleteReservation .modal-footer button:first-child').on('click', function () {
    var $passager_card = $('#annonce .passager-card.selected');

    $id_reservation = $passager_card.data("reserv");

    $.ajax({
        url: $_DOMAIN + 'cancel_reservation.php',
        type: 'POST',
        data: {
            id_reservation: $id_reservation
        },
        success: function (data) {
            if (data == 'error') {
                $('#annonce #deleteReservation').modal('hide');
                $passager_card.next('.alert').removeClass('d-none').html(errorMessage);
            }
            else {
                $('#annonce .passager-card.selected').addClass('d-none');
                $('#annonce #deleteReservation').modal('hide');
            }
        },
        error: function () {
            $('#annonce #deleteReservation').modal('hide');
            $passager_card.next('.alert').removeClass('d-none').html(errorMessage);
        }
    });
});

/*
 * Update profile
 */
$('#formUpdateProfile button.save').on('click', function (event) {
    event.preventDefault();
    var $update_prenom = $('#formUpdateProfile #update_prenom').val(),
        $update_nom = $('#formUpdateProfile #update_nom').val(),
        $update_age = $('#formUpdateProfile #update_age').val(),
        $update_sexe = $('#formUpdateProfile .custom-control-input:checked').val(),
        $update_telephone = $('#formUpdateProfile #update_telephone').val(),
        $update_url_avatar = $('#formUpdateProfile #update_avatar').val(),
        $update_password = $('#formUpdateProfile #update_password').val(),
        $confirm_password = $('#formUpdateProfile #confirm_password').val();

    var data = {
        prenom: $update_prenom,
        nom: $update_nom,
        age: $update_age,
        sexe: $update_sexe,
        telephone: $update_telephone,
        url_avatar: $update_url_avatar,
        password: $update_password
    };

    if ($update_password == $confirm_password) {
        $.ajax({
            url: $_DOMAIN + 'profile.php',
            type: 'POST',
            data: data,
            success: function (response) {
                $('#formUpdateProfile .alert').parent().removeClass('d-none');
                $('#formUpdateProfile .alert').html(response);
            }
        });
    }
    else {
        if ($update_password == '' && $confirm_password != '') {
            $('#formUpdateProfile #update_password').addClass('is-invalid');
            $('#formUpdateProfile #update_password').next().html('Veuillez compléter ce champ');
        }
        else {
            $('#formUpdateProfile #confirm_password').addClass('is-invalid');
            $('#formUpdateProfile #confirm_password').next().html('Mot de passe incorrect');
        }
    }
})