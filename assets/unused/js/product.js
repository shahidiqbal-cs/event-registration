jQuery(document).ready(function () {
    if (typeof base_url === 'undefined') {
        base_url = 'http://localhost/ci_shades';
    }

    jQuery('.number').keydown(function (event) {
        // Allow only backspace and delete
        if (event.keyCode == 46 || event.keyCode == 8) {
            // let it happen, don't do anything
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.keyCode < 48 || event.keyCode > 57) {
                event.preventDefault();
            }
        }
    });

    jQuery('#add-to-cart-form').submit(function () {
        // Get the product ID and the quantity
        jQuery('#add-to-cart-btn').attr('disabled', 'disabled');

        var id = jQuery('#product_id').val();
        var qty = jQuery('#product_quantity').val();
        jQuery('#cart-message').removeClass();
        if (id === '' || id === '0') {
            jQuery('#cart-message').html('Unexpected error occurred.... Reload page and try again.');
            jQuery('#cart-message').addClass('alert alert-danger');
            jQuery('#add-to-cart-btn').removeAttr('disabled');
        } else if (qty === '' || qty === '0') {
            jQuery('#cart-message').html('Please set the quantity of product.');
            jQuery('#cart-message').addClass('alert alert-warning');
            jQuery('#add-to-cart-btn').removeAttr('disabled');
        } else if (isNaN(qty)) {
            jQuery('#cart-message').html('Enter vaild quantity');
            jQuery('#cart-message').addClass('alert alert-info');
            jQuery('#add-to-cart-btn').removeAttr('disabled');
        } else {
            jQuery.ajax({
                type: 'post',
                url: base_url + 'cart/add_item_to_cart',
                cache: false,
                data: {
                    product_id: id,
                    quantity: qty
                },
                success: function (json) {
                    var response = jQuery.parseJSON(json);
                    if (response.status === true) {
                        //response.row_id
                        jQuery('#cart-message').html('Product is added to cart.');
                        jQuery('#cart-message').addClass('alert alert-success');
                        jQuery('#cart_total_item').html(response.cart_items);
                    } else {
                        jQuery('#cart-message').html('Unexpected error occurred.... Reload page and try again.');
                        jQuery('#cart-message').addClass('alert alert-danger');
                    }
                }
            });
        }
        return false; // Stop the reloading page
    });

    jQuery('#registeration').submit(function () {
        // Get the product ID and the quantity
        jQuery('#registeration-btn').attr('disabled', 'disabled');

        var name = jQuery('#name').val();
        var email = jQuery('#email').val();
        var password = jQuery('#password').val();
        var fedback = jQuery('#fedback').val();
        var name_valid = true;
        var email_valid = true;
        var pass_valid = true;
        var required = false;
        jQuery('#registeration-message').html('');
        jQuery('#registeration-message').removeClass('msg error sucess');

        if (name === '') {
            required = true;
            jQuery('#name').addClass('alert alert-danger');
        } else {
            jQuery('#name').removeClass('alert alert-danger');
        }
        if (email === '') {
            required = true;
            jQuery('#email').addClass('alert alert-danger');
        } else {
            jQuery('#email').removeClass('alert alert-danger');
        }
        if (password === '') {
            required = true;
            jQuery('#password').addClass('alert alert-danger');
        } else {
            jQuery('#password').removeClass('alert alert-danger');
        }
        if (required === true) {
            jQuery('#registeration-message').html('Above fields are requireds.');
            jQuery('#registeration-message').addClass('msg error');
            jQuery('#registeration-btn').removeAttr('disabled');
        } else {
            if (!vaildateName(name)) {
                name_valid = false;
                jQuery('#name').addClass('alert alert-danger');
            } else {
                jQuery('#name').removeClass('alert alert-danger');
            }
            if (!validateEmail(email)) {
                email_valid = false;
                jQuery('#email').addClass('alert alert-danger');
            } else {
                jQuery('#email').removeClass('alert alert-danger');
            }
            if (password.length < 6) {
                pass_valid = false;
                jQuery('#password').addClass('alert alert-danger');
            } else {
                jQuery('#password').removeClass('alert alert-danger');
            }
            if (!name_valid || !email_valid || !pass_valid) {
                if (!name_valid && !email_valid && !pass_valid) {
                    jQuery('#registeration-message').html('Enter vaild name,email and password must be at least six length.');
                } else if (!name_valid && !email_valid) {
                    jQuery('#registeration-message').html('Enter vaild name and email.');
                } else if (!name_valid && !pass_valid) {
                    jQuery('#registeration-message').html('Enter vaild name and password must be at least six length.');
                } else if (!email_valid && !pass_valid) {
                    jQuery('#registeration-message').html('Enter vaild email and password must be at least six length.');
                } else if (!name_valid) {
                    jQuery('#registeration-message').html('Enter vaild name.');
                } else if (!email_valid) {
                    jQuery('#registeration-message').html('Enter vaild email.');
                } else {
                    jQuery('#registeration-message').html('Password must be at least six.');
                }
                jQuery('#registeration-message').addClass('msg error');
                jQuery('#registeration-btn').removeAttr('disabled');
            } else {
                jQuery('#registeration-message').html('');
                jQuery('#registeration-message').removeClass('msg error');
                jQuery.ajax({
                    type: 'post',
                    url: base_url + 'user/register',
                    cache: false,
                    data: {
                        name: name,
                        email: email,
                        password: password,
                        fedback: fedback,
                    },
                    success: function (json) {
                        var response = jQuery.parseJSON(json);
                        if (response.status === true) {
                            window.location = response.redirect;
                        } else {
                            jQuery('#registeration-message').html(response.message);
                            jQuery('#registeration-message').addClass('msg error');
                            jQuery('#registeration-btn').removeAttr('disabled');
                        }
                    }
                });
            }
        }
        return false; // Stop the reloading page
    });
    jQuery('#login').submit(function () {
        // Get the product ID and the quantity
        jQuery('#login-btn').attr('disabled', 'disabled');

        var email = jQuery('#login_email').val();
        var password = jQuery('#login_password').val();
        var email_valid = true;
        var pass_valid = true;
        var required = false;
        jQuery('#login-message').html('');
        jQuery('#login-message').removeClass('msg error sucess');

        if (email === '') {
            required = true;
            jQuery('#login_email').addClass('alert alert-danger');
        } else {
            jQuery('#login_email').removeClass('alert alert-danger');
        }
        if (password === '') {
            required = true;
            jQuery('#login_password').addClass('alert alert-danger');
        } else {
            jQuery('#login_password').removeClass('alert alert-danger');
        }
        if (required === true) {
            jQuery('#login-message').html('Above fields are requireds.');
            jQuery('#login-message').addClass('msg error');
            jQuery('#login-btn').removeAttr('disabled');
        } else {
            if (!validateEmail(email)) {
                email_valid = false;
                jQuery('#login_email').addClass('alert alert-danger');
            } else {
                jQuery('#login_email').removeClass('alert alert-danger');
            }
            if (password.length < 6) {
                pass_valid = false;
                jQuery('#login_password').addClass('alert alert-danger');
            } else {
                jQuery('#login_password').removeClass('alert alert-danger');
            }
            if (!email_valid || !pass_valid) {
                if (!email_valid && !pass_valid) {
                    jQuery('#login-message').html('Enter vaild email and password must be at least six length.');
                } else if (!email_valid) {
                    jQuery('#login-message').html('Enter vaild email.');
                } else {
                    jQuery('#login-message').html('Password must be at least six.');
                }
                jQuery('#login-message').addClass('msg error');
                jQuery('#login-btn').removeAttr('disabled');
            } else {
                jQuery('#login-message').html('');
                jQuery('#login-message').removeClass('msg error');
                jQuery.ajax({
                    type: 'post',
                    url: base_url + 'user/login',
                    cache: false,
                    data: {
                        email: email,
                        password: password
                    },
                    success: function (json) {
                        var response = jQuery.parseJSON(json);
                        if (response.login === true) {
                            window.location = response.redirect;
                        } else {
                            jQuery('#login-message').html(response.message);
                            jQuery('#login-message').addClass('msg error');
                            jQuery('#login-btn').removeAttr('disabled');
                        }
                    }
                });
            }
        }
        return false; // Stop the reloading page
    });
    jQuery('#login-at-checkout').submit(function () {
        // Get the product ID and the quantity
        jQuery('#login-at-checkout-btn').attr('disabled', 'disabled');

        jQuery('ul.form-error').remove();
        var email = jQuery('#login-at-checkout-email').val();
        var password = jQuery('#login-at-checkout-password').val();
        var error_string = '';

        if (email === '') {
            error_string = error_string + '<li><span>Email</span> is a required for login.</li>';
        } else if (!validateEmail(email)) {
            error_string = error_string + '<li><span>Email</span> is not valid you provide.</li>';
        }
        if (password === '') {
            error_string = error_string + '<li><span>Password</span> is a required for login.</li>';
        } else if (password.length < 6) {
            error_string = error_string + '<li><span>Password</span> must be at least six in length.</li>';
        }

        if (error_string !== '') {
            error_string = '<ul class="form-error">' + error_string + '</ul>';
            jQuery(this).before(error_string);
            jQuery('#login-at-checkout-btn').removeAttr('disabled');
        } else {
            jQuery.ajax({
                type: 'post',
                url: base_url + 'user/login',
                cache: false,
                data: {
                    email: email,
                    password: password
                },
                success: function (json) {
                    var response = jQuery.parseJSON(json);
                    if (response.login === true) {
                        window.location.reload();
                    } else {
                        error_string = '<ul class="form-error"><li>' + response.message + '</li></ul>';
                        jQuery('#login-at-checkout').before(error_string);
                        jQuery('#login-at-checkout-btn').removeAttr('disabled');
                    }
                }
            });

//            var current_url = window.location.reload();
//            alert(current_url);
        }
        return false; // Stop the reloading page
    });
    jQuery('#processed-to-checkout').submit(function () {
        var user_password = '';
        var message = jQuery('#check-out-messages');
        var ship_to_another_address = jQuery('#ship-to-different-address-checkbox').prop('checked');
        var is_logged = jQuery(this).find('input[name=logged]').val();
        jQuery(this).find('input[name=submit]').attr('disabled', 'disabled');
        jQuery('ul.form-error').remove();
        message.html('');
        message.removeClass();
        var error_string = '';

        ///////////////////////////// Billing section /////////////////////////////
        var billing_fname = jQuery(this).find('input[name=billing_fname]').val();
        var billing_lname = jQuery(this).find('input[name=billing_lname]').val();
        var billing_company_name = jQuery(this).find('input[name=billing_company_name]').val();
        var billing_address = jQuery(this).find('input[name=billing_address]').val();
        var billing_city = jQuery(this).find('input[name=billing_city]').val();
        var billing_country = jQuery(this).find('select[name=billing_country]').val();
        var billing_state = jQuery(this).find('input[name=billing_state]').val();
        var billing_zip = jQuery(this).find('input[name=billing_zip]').val();
        var billing_email = jQuery(this).find('input[name=billing_email]').val();
        var billing_phone = jQuery(this).find('input[name=billing_phone]').val();

        if (billing_fname === '') {
            error_string = error_string + '<li><span>Billing Name</span> is a required field.</li>';
        } else if (!vaildateName(billing_fname)) {
            error_string = error_string + '<li><span>Billing Name</span> is not vaild.</li>';
        }
        if (billing_lname === '') {
            error_string = error_string + '<li><span>Billing Last Name</span> is a required field.</li>';
        } else if (!vaildateName(billing_lname)) {
            error_string = error_string + '<li><span>Billing Last Name</span> is not vaild.</li>';
        }
        if (billing_address === '') {
            error_string = error_string + '<li><span>Billing Address</span> is a required field.</li>';
        }
        if (billing_city === '') {
            error_string = error_string + '<li><span>Billing City</span> is a required field.</li>';
        }
        if (billing_country === '') {
            error_string = error_string + '<li><span>Billing Country</span> is a required field.</li>';
        }
        if (billing_state === '') {
            error_string = error_string + '<li><span>Billing State</span> is a required field.</li>';
        }
        if (billing_zip === '') {
            error_string = error_string + '<li><span>Billing Zip</span> is a required field.</li>';
        } else if (!vaildateZip(billing_zip)) {
            error_string = error_string + '<li><span>Billing Zip</span> is not vaild.</li>';
        }
        if (billing_email === '') {
            error_string = error_string + '<li><span>Billing Email</span> is a required field.</li>';
        } else if (!validateEmail(billing_email)) {
            error_string = error_string + '<li><span>Billing Email</span> is not vaild.</li>';
        }
        if (billing_phone === '') {
            error_string = error_string + '<li><span>Billing Phone</span> is a required field.</li>';
        } else if (!validatePhone(billing_phone)) {
            error_string = error_string + '<li><span>Billing Phone</span> is not vaild.</li>';
        }
        ///////////////////////////// End Billing section /////////////////////////////
        //
        /////////////////////////////// Shipping section /////////////////////////////
        if (ship_to_another_address) {
            var shipping_fname = jQuery(this).find('input[name=shipping_fname]').val();
            var shipping_lname = jQuery(this).find('input[name=shipping_lname]').val();
            var shipping_company_name = jQuery(this).find('input[name=shipping_company_name]').val();
            var shipping_address = jQuery(this).find('input[name=shipping_address]').val();
            var shipping_city = jQuery(this).find('input[name=shipping_city]').val();
            var shipping_country = jQuery(this).find('select[name=shipping_country]').val();
            var shipping_state = jQuery(this).find('input[name=shipping_state]').val();
            var shipping_zip = jQuery(this).find('input[name=shipping_zip]').val();
            if (shipping_fname === '') {
                error_string = error_string + '<li><span>Shipping Name</span> is a required field.</li>';
            } else if (!vaildateName(shipping_fname)) {
                error_string = error_string + '<li><span>Shipping Name</span> is not vaild.</li>';
            }
            if (shipping_lname === '') {
                error_string = error_string + '<li><span>Shipping Last Name</span> is a required field.</li>';
            } else if (!vaildateName(shipping_lname)) {
                error_string = error_string + '<li><span>Shipping Last Name</span> is not vaild.</li>';
            }
            if (shipping_address === '') {
                error_string = error_string + '<li><span>Shipping Address</span> is a required field.</li>';
            }
            if (shipping_city === '') {
                error_string = error_string + '<li><span>Shipping City</span> is a required field.</li>';
            }
            if (shipping_country === '') {
                error_string = error_string + '<li><span>Shipping Country</span> is a required field.</li>';
            }
            if (shipping_state === '') {
                error_string = error_string + '<li><span>Shipping State</span> is a required field.</li>';
            }
            if (shipping_zip === '') {
                error_string = error_string + '<li><span>Shipping Zip Code</span> is a required field.</li>';
            } else if (!vaildateZip(shipping_zip)) {
                error_string = error_string + '<li><span>Shipping Zip</span> is not vaild.</li>';
            }
        }
        /////////////////////////////// End Shipping section /////////////////////////////
        //Register as new user
        if (is_logged !== '1') {
            var user_password = jQuery(this).find('input[name=user_password]').val();
            if (user_password === '') {
                error_string = error_string + '<li><span>Password</span> is a required field.</li>';
            }
        }
        if (error_string !== '') {
            error_string = '<ul class="form-error">' + error_string + '</ul>';
            jQuery(this).before(error_string);
            jQuery(this).find('input[name=submit]').removeAttr('disabled');
        } else {
            var billing_info = {
                billing_fname: billing_fname,
                billing_lname: billing_lname,
                billing_company_name: billing_company_name,
                billing_address: billing_address,
                billing_city: billing_city,
                billing_country: billing_country,
                billing_state: billing_state,
                billing_zip: billing_zip,
                billing_email: billing_email,
                billing_phone: billing_phone,
            };

            var shipping_info = {
                shipping_fname: '',
                shipping_lname: '',
                shipping_company_name: '',
                shipping_address: '',
                shipping_city: '',
                shipping_country: '',
                shipping_state: '',
                shipping_zip: '',
            };
            if (ship_to_another_address) {
                shipping_info = {
                    shipping_fname: shipping_fname,
                    shipping_lname: shipping_lname,
                    shipping_company_name: shipping_company_name,
                    shipping_address: shipping_address,
                    shipping_city: shipping_city,
                    shipping_country: shipping_country,
                    shipping_state: shipping_state,
                    shipping_zip: shipping_zip,
                };
            }
            var action_method = base_url + 'user/register';
            if (is_logged === '1') {
                action_method = base_url + 'user/update_info';
                message.addClass('alert alert-info');
                message.html('Hold on! Updating your billing/shipping info...');
            } else {
                message.addClass('alert alert-info');
                message.html('Hold on! Registering you first...');
            }
            jQuery.ajax({
                type: 'post',
                url: action_method,
                cache: false,
                data: {
                    name: billing_fname,
                    email: billing_email,
                    password: user_password,
                    fedback: '',
                    billing_info: billing_info,
                    shipping_info: shipping_info,
                },
                success: function (json) {
                    var response = jQuery.parseJSON(json);
                    if (response.status === true) {
                        message.addClass('alert alert-info');
                        message.html('Connecting with paypal! Please wait...');
                        if (!ship_to_another_address) {
                            shipping_info = {
                                shipping_fname: billing_fname,
                                shipping_lname: billing_lname,
                                shipping_company_name: billing_company_name,
                                shipping_address: billing_address,
                                shipping_city: billing_city,
                                shipping_country: billing_country,
                                shipping_state: billing_state,
                                shipping_zip: billing_zip,
                            };
                        }
                        jQuery.ajax({
                            type: 'post',
                            url: base_url + 'payment/set_express_checkout',
                            cache: false,
                            data: {
                                billing_info: billing_info,
                                shipping_info: shipping_info,
                            },
                            success: function (json) {
                                var response_payment = jQuery.parseJSON(json);
                                if (response_payment.status === true) {
                                    message.addClass('alert alert-success');
                                    message.html(response_payment.message);
                                    window.location = response_payment.redirect;
                                } else {
                                    message.addClass('alert alert-danger');
                                    message.html(response_payment.message);
                                    jQuery(this).find('input[name=submit]').removeAttr('disabled');
                                }
                            }
                        });
                    } else {
                        message.addClass('alert alert-danger');
                        message.html(response.message);
                        jQuery(this).find('input[name=submit]').removeAttr('disabled');
                    }
                }
            });
        }
        return false; // Stop the reloading page
    });


});

function validateEmail(email) {
    var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    return re.test(email);

}
//return false if not vaild
function vaildateName(name) {
    var re = /^[A-z ]+$/;
    return re.test(name);
}

function vaildateZip(zip) {
    var re = /^\d{5}$/;
    return re.test(zip);
}
function validatePhone(number) {
    var re = /^[0-9-+]+$/;
    return re.test(number);
}