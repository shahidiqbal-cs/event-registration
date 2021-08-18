jQuery(document).ready(function () {
    // Drop Down Menu
    jQuery("#st_main_menu ul li ul ").css({display: "none"}); // Opera Fix
    jQuery("#st_main_menu li").hover(function () {
        jQuery(this).addClass("activeLink");
        jQuery(this).find('ul:first').css({visibility: "visible", display: "none"}).fadeIn(300);
    }, function () {
        jQuery(this).removeClass("activeLink");
        jQuery(this).find('ul:first').fadeOut(300);
    });

// Field Label
    jQuery('input[type="text"]').focus(function () {
        if (this.value == this.defaultValue) {
            this.value = '';
        }
        if (this.value != this.defaultValue) {
            this.select();
        }
    });
    jQuery('input[type="text"]').blur(function () {
        if (this.value == '') {
            this.value = this.defaultValue;
        }
    });
    jQuery('input[type="email"]').focus(function () {
        if (this.value == this.defaultValue) {
            this.value = '';
        }
        if (this.value != this.defaultValue) {
            this.select();
        }
    });
    jQuery('input[type="email"]').blur(function () {
        if (this.value == '') {
            this.value = this.defaultValue;
        }
    });
    jQuery('textarea').focus(function () {
        if (this.value == this.defaultValue) {
            this.value = '';
        }
        if (this.value != this.defaultValue) {
            this.select();
        }
    });
    jQuery('textarea').blur(function () {
        if (this.value == '') {
            this.value = this.defaultValue;
        }
    });

    // Mobile
    /*$('.btn-menu').click(function(e) {
     $('#menu').slideToggle(100);
     });*/

    //Popups
    jQuery('.st_login_btn').click(function () {
        jQuery('#st_popup_overlay').fadeIn(300);
        jQuery(this).parent().find('.st_popup').fadeIn(600);
    });
    jQuery('.st_close_popup').click(function () {
        jQuery(this).parent('.st_popup').fadeOut(300);
        jQuery('#st_popup_overlay').fadeOut(600);
    });

    jQuery("body").mouseup(function (e) {
        var subject = jQuery(".st_popup");
        var subjectoverlay = jQuery("#st_popup_overlay");

        if (e.target.id != subject.attr('id') && !subject.has(e.target).length)
        {
            subject.fadeOut(300);
            subjectoverlay.fadeOut(400);
        }


    });
    //Slider for the product
    jQuery('#carousel span').append('<img src="../assets/images/carousel_glare.png" class="glare" />');
    jQuery('#thumbs a').append('<img src="../assets/images/carousel_glare_small.png" class="glare" />');
    jQuery('#carousel').carouFredSel({
        responsive: true,
        circular: false,
        auto: false,
        items: {
            visible: 1,
            width: 200,
            height: '56%'
        },
        scroll: {
            fx: 'directscroll'
        }
    });
    jQuery('#thumbs').carouFredSel({
        responsive: true,
        circular: false,
        infinite: false,
        auto: false,
        prev: '#prev',
        next: '#next',
        items: {
            visible: {
                min: 5,
                max: 6
            },
            width: 150,
            height: '66%'
        }
    });
    jQuery('#thumbs a').click(function () {
        jQuery('#carousel').trigger('slideTo', '#' + this.href.split('#').pop());
        jQuery('#thumbs a').removeClass('selected');
        jQuery(this).addClass('selected');
        return false;
    });
    //End slider for the product

    //Radio option on product listing
    jQuery('.radiodemo').fatoggle(['fa-circle-o', 'fa-dot-circle-o'], {
        'radio': true,
        'classes': ['fa', 'fa-li'],
        'toggleOn': function (e) {
            jQuery('#radiooutput').html('You selected ' + $(e).parent().text());
        },
        'toggleOff': function (e) {
            jQuery('#radiooutput').html('');
        }
    });

    jQuery(window).load(function () {

        var amount = Math.max.apply(Math, jQuery("#content-1 li").map(function () {
            return jQuery(this).outerWidth(true);
        }).get());

        jQuery("#content-1").mCustomScrollbar({
            axis: "x",
            theme: "inset",
            advanced: {
                autoExpandHorizontalScroll: true
            },
            scrollButtons: {
                enable: true,
                scrollType: "stepped"
            },
            keyboard: {scrollType: "stepped"},
            snapAmount: amount,
            mouseWheel: {scrollAmount: amount}
        });

    });
    jQuery('#login-form-toggle').click(function () {
        jQuery('#login-at-checkout').toggle();
    });
    jQuery('#ship-to-different-address-checkbox').click(function () {
        jQuery('.shipping_address').toggle();
    });

//    Cufon.replace('.st_blog_text h4, .st_blog_desc h4');
});
