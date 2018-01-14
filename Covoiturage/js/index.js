var $_DOMAIN = 'http://localhost/Covoiturage/';

$(document).ready(function() {

	// variables of login and sign up form
	var $form_modal = $('.cd-user-modal'),
		$form_login = $form_modal.find('#cd-login'),
		$form_signup = $form_modal.find('#cd-signup'),
		$form_forgot_password = $form_modal.find('#cd-reset-password'),
		$form_modal_tab = $('.cd-switcher'),
		$tab_login = $form_modal_tab.children('li').eq(0).children('a'),
		$tab_signup = $form_modal_tab.children('li').eq(1).children('a'),
		$forgot_password_link = $form_login.find('.cd-form-bottom-message a'),
		$back_to_login_link = $form_forgot_password.find('.cd-form-bottom-message a'),
		$main_nav = $('.main-nav');

	// variables of profile menu navigation
	var $profile_nav = $('.profile-nav'),
		$dropdown_userMenu = $('.dropdown--userMenu'),
		$bars = $profile_nav.find('.fa');

	// variables of live search form
	var $form_live_search = $('.live-search-form'),
		$field_wrap = $form_live_search.find('.field-wrap'),
		$live_search = $form_live_search.find('.live-search');

	//open modal
	$main_nav.on('click', function(event){
		var $target = $(event.target);
		if( $target.is($main_nav) ) {
			// on mobile open the submenu
			$(this).children('ul').toggleClass('is-visible');
		} else {
			// on mobile close submenu
			$main_nav.children('ul').removeClass('is-visible');
			if ($target.is('.cd-signup') || $target.is('.cd-signin')) {
                //show modal layer
                $form_modal.addClass('is-visible');
                //show the selected form
                ( $target.is('.cd-signup') ) ? signup_selected() : login_selected();
			}
		}

	});

	//close modal
	$('.cd-user-modal').on('click', function(event){
		if( $(event.target).is($form_modal) || $(event.target).is('.cd-close-form') ) {
			$form_modal.removeClass('is-visible');
		}	
	});
	//close modal when clicking the esc keyboard button
	$(document).keyup(function(event){
    	if(event.which=='27'){
    		$form_modal.removeClass('is-visible');
	    }
    });

	//switch from a tab to another
	$form_modal_tab.on('click', function(event) {
		event.preventDefault();
		( $(event.target).is( $tab_login ) ) ? login_selected() : signup_selected();
	});

	//hide or show password
	$('.hide-password').on('click', function(){
		var $this= $(this),
			$password_field = $this.prev().prev('input');
		
		( 'password' == $password_field.attr('type') ) ? $password_field.attr('type', 'text') : $password_field.attr('type', 'password');
		( 'Cacher' == $this.text() ) ? $this.text('Montrer') : $this.text('Cacher');
		//focus and move cursor to the end of input field
		//$password_field.putCursorAtEnd();
	});

	//show forgot-password form 
	$forgot_password_link.on('click', function(event){
		event.preventDefault();
		forgot_password_selected();
	});

	//back to login from the forgot-password form
	$back_to_login_link.on('click', function(event){
		event.preventDefault();
		login_selected();
	});

	function login_selected(){
		$form_login.addClass('is-selected');
		$form_signup.removeClass('is-selected');
		$form_forgot_password.removeClass('is-selected');
		$tab_login.addClass('selected');
		$tab_signup.removeClass('selected');
	}

	function signup_selected(){
		$form_login.removeClass('is-selected');
		$form_signup.addClass('is-selected');
		$form_forgot_password.removeClass('is-selected');
		$tab_login.removeClass('selected');
		$tab_signup.addClass('selected');
	}

	function forgot_password_selected(){
		$form_login.removeClass('is-selected');
		$form_signup.removeClass('is-selected');
		$form_forgot_password.addClass('is-selected');
	}

	// remove error messages when focus
	$form_login.find('input[type="text"], input[type="password"]').on('focus', function() {
		$(this).removeClass('has-error').next('span').removeClass('is-visible');
	});
    $form_signup.find('input[type="text"], input[type="password"], input[type="email"]').on('focus', function() {
        $(this).removeClass('has-error').next('span').removeClass('is-visible');
    });

	/*
	 * Permettre de fermer les popovers quand on clique en dehor
	 */
	$(document).on('click', function(event) {
		var target = event.target;

        // Open and close profile menu navigation
		if (!$bars.is(target) && !$dropdown_userMenu.is(target) && !$dropdown_userMenu.has(target).length) {
			$dropdown_userMenu.removeClass('is-visible');
		}
		else if ($bars.is(event.target)) {
			$dropdown_userMenu.toggleClass('is-visible');
		}

		// Close live search
		$live_search.each(function() {
			if ($(this).children('ul').html() !== '') {
				if ($(target).is('.live-search li') || (!$(this).has(target).length && !$(this).parent().has(target).length)) {
					$(this).addClass('invisible');
				}
			}
		});

		// Close popover-custom
		if (!$('#annonce .card.selected .popover-custom').is(target)) {
            $('#annonce .card.selected .popover-custom').addClass('d-none');
		}

	});

	// live search AJAX va PHP
    $('#formSearchTrip #end_Address, #formPostTrip #post_arrive, #finder #destination_input')// start_Adress, end_Adresse
		.on('keyup', function (event) {
			var $this = $(this),
				$location_value = $this.val();

			if ($location_value == '') {
				$this.next('.live-search').html('');
			}
			else {
				$.ajax({
					url: $_DOMAIN + 'livesearch.php',
					type: 'GET',
					data: {
						location_value: $location_value
					},
					success: function(data) {
						data = '<ul>' + data + '</ul>';
						$this.next('.live-search').html(data);
					}
				});
			}
		});
    $('#formSearchTrip #end_Address,#formPostTrip #post_arrive, #finder #destination_input')
		.on('click', function() {					// xuat hien lai live search
        	$(this).next().removeClass('invisible');
    	})
        .on('change', function() {					// Khi thay doi gia tri cua input thi xoa class error
            $(this).removeClass('error');
			//$('#formSearchTrip').parent().next().addClass('invisible');
        });


    // lay gia tri search vao input
	$field_wrap.on('click', function(evt) {
		var $this = $(this); // $(this) nay tro den origin hoac destination
		$this.find('li').each(function() {
			// $(this) nay tro den li
            if ($(evt.target).is($(this))) {
            	$this.children('input').val($(evt.target).text()); // gán giá trị đang click vào input
            	$(this).parent().html($(this)); // giữ lại chính nó trong live search
			}
		});
	});

	// date time picker Bootstrap 3
	$('.date').datetimepicker({
        format:'YYYY-MM-DD',
        icons: {
            date: "fa fa-calendar"
        }
	});
	var currentDate = new Date();
	// deo biet loi gi, tu nhien bat loi undefined
	if (typeof $('#date_input').parent().data("DateTimePicker") !== 'undefined') {
        $('#date_input').parent().data("DateTimePicker").minDate(currentDate);
	}
	$('.time').datetimepicker({
		format: 'HH:mm',
		icons: {
			time: "fa fa-clock-o"
		}
	});

	// Range slider departure and arrive time
    var rangeSlider = function(){
        var $slider = $('.range-slider'),
            $range = $('.range-slider__range'),
            $value = $('.range-slider__value');

        $slider.each(function(){
            $value.each(function(){
                var value = $(this).next().attr('value');
                $(this).html(value);
            });

            $range.on('input', function(){
                $(this).prev($value).html(this.value); // this.value == $(this).val()
            });
        });
    };
    rangeSlider();

    /*----- Step nav POST -----*/
    var navListItems = $('div.setup-panel div a'),
        allWells = $('.setup-content'),
        allNextBtn = $('.nextBtn'),
		allPrevBtn = $('.prevBtn'),
		$modifyStep = $('.modify');

    allWells.hide();

    navListItems.click(function (e) {
        e.preventDefault();
        processStep($(this));
    });

    $('#formPostTrip .custom-checkbox').on('click', function() {
    	if ($(this).find('input[type="checkbox"]').prop("checked")==true) {
    		$('#post_hour_retour, #post_date_retour, #post_place_retour').closest('.form-group').removeClass('d-none');
    		$('.submit-retour').removeClass('d-none');

            $('#post_date').parent().on('dp.change', function(event) {
                $('#post_date_retour').parent().data("DateTimePicker").minDate(event.date);
            });

            $('#post_date_retour').parent().on('dp.change', function(event) {
                $('#post_date').parent().data("DateTimePicker").maxDate(event.date);
            });
		} else {
            $('#post_hour_retour, #post_date_retour, #post_place_retour').closest('.form-group').addClass('d-none');
            $('.submit-retour').addClass('d-none');
		}
	});

    allNextBtn.click(function(event){
		processBtn($(this));
		//	Xu ly cac gia tri o phan publication
		if ($(this).closest(".setup-content").is('#step-1')) {
            $("#submit_depart").html($("#post_depart").val());
            $("#submit_arrive").html($("#post_arrive").val());
		} else if ($(this).closest(".setup-content").is('#step-2')) {
			$("#submit_place").html($("#post_place option:selected").val());
		} else if ($(this).closest(".setup-content").is('#step-3')) {
			$("#submit_date").html($("#post_date").val());
			$("#submit_hour").html($("#post_hour").val());
			if (!$('.submit-retour').closest('.form-group').hasClass('d-none')) {
				$('#submit_date_retour').html($('#post_date_retour').val());
				$('#submit_hour_retour').html($('#post_hour_retour').val());
				$('#submit_place_retour').html($('#post_place_retour option:selected').val());
			}
		}
    });

    allPrevBtn.click(function() {
		processBtn($(this));
	});

    $modifyStep.click(function() {
    	$curStep = $('.setup-panel div a[href="'+$(this).attr("href")+'"]');
    	processStep($curStep);
	});

    $('div.setup-panel div a.btn-primary').trigger('click');

    function processStep($step) {
        var $target = $($step.attr('href')),		// setup-content ayant id step-*
            $item = $step;							// stepwizard-step a sélectionné

        if (!$item.hasClass('disabled')) {
            /*
             * désactiver les balises anchors après l'anchor sélectionné
             */
            var $nextStep = $item.parent().next();
            while ($nextStep.length == 1) {					// s'il y a div.stepwizard-step suivant
                $nextStep.find('a').addClass('disabled');	// désactiver
                $nextStep = $nextStep.next();				// passer le suivant
            }

            navListItems.removeClass('btn-primary').addClass('btn-dark');
            $item.removeClass('btn-dark').addClass('btn-primary');

            allWells.hide();
            $target.show();
            $target.find('input:eq(0)').focus();

        }
    }
    function processBtn($btn) {
        var $curStep = $btn.closest(".setup-content"),
            $curStepWizard = $('div.setup-panel div a[href="#' + $curStep.attr("id") + '"]'),
            $prevStepWizard = $curStepWizard.parent().prev().children("a"),
            $nextStepWizard = $curStepWizard.parent().next().children("a"),
            $curInputs = $curStep.find(".form-group:not('.d-none') input[type='text']"),
            isValid = true;

        $(".form-control").removeClass("is-invalid");
        for(var i=0; i<$curInputs.length; i++){
            if (!$curInputs[i].validity.valid){
                isValid = false;
                $($curInputs[i]).addClass("is-invalid");
            }
        }

        // Neu click precedant
        if ($btn.hasClass('prevBtn')) {
            $curStepWizard.addClass('disabled');
            $prevStepWizard.removeClass('disabled').trigger('click');
        }
        // Neu click suivant
        else {
            if (isValid)
                $nextStepWizard.removeClass('disabled').trigger('click');
        }
    }
    /*-------------------------*/
    $('#summernote').summernote({
        tabsize: 2,
        height: 100
    });
    $('#message_texte').summernote({
		tabsize: 3,
		height: 300
	});


});

//credits https://css-tricks.com/snippets/jquery/move-cursor-to-end-of-textarea-or-input/
/*$.fn.putCursorAtEnd = function() {
	return this.each(function() {
    	// If this function exists...
    	if (this.setSelectionRange) {
      		// ... then use it (Doesn't work in IE)
      		// Double the length because Opera is inconsistent about whether a carriage return is one character or two. Sigh.
      		var len = $(this).val().length * 2;
      		this.setSelectionRange(len, len);
    	} else {
    		// ... otherwise replace the contents with itself
    		// (Doesn't work in Google Chrome)
      		$(this).val($(this).val());
    	}
	});
};*/