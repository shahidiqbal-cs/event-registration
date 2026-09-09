jQuery(document).ready(function () {
    /******************************* Common scripts ******************************/
    var message_in_print_header = '';
    jQuery("[data-mask]").inputmask();
    //jQuery('#data_table').DataTable();
    jQuery('.datePicker').datepicker({format: 'yyyy-mm-dd'});
    if (typeof site_base_url === 'undefined') {
        site_base_url = 'http://localhost';
    }
    if (jQuery('#print_page_header_message').length) {
        message_in_print_header = document.getElementById('print_page_header_message').innerHTML;
    }
    //iCheck for checkbox and radio inputs
    load_event_with_icheck();
    jQuery('#data_table').DataTable({
        paging: true,
        lengthChange: true,
        searching: true,
        ordering: true,
        order: [[ 0, "asc" ]],
        info: true,
        autoWidth: false,
        displayLength: 25,
        lengthMenu: [
            [10, 25, 50, -1],
            ['10 rows', '25 rows', '50 rows', 'Show all']
        ],
        dom: '<"#print_header">Blfrtip<"#print_footer">', //Bltrvf,Bfrtip,lfrtip,lrtip
        buttons: [
//            'pageLength', 'print', 'csv', 'pdf', 'excel'
            {
                extend: 'print',
                text: 'Print current page',
                autoPrint: false,
                header: true,
                footer: false,
                title: '',
                message: message_in_print_header,
                customize: function (win) {
                    jQuery(win.document.body).addClass('printing_section');
                    jQuery(win.document.body).find('table').css('font-size', '14px');
                },
                exportOptions: {
//                    format: {
//                        header: function (data, columnIdx) {
//                            return columnIdx + ': ' + data;
//                        }
//                    }
                }
//                key: {
//                    key: 'p',
//                    altkey: true
//                }
            },
            'csv', 'pdf', 'excel'
        ],
    });
    /*DOM
     l - Length changing
     f - Filtering input
     t - The Table!
     i - Information
     p - Pagination
     r - pRocessing
     < and > - div elements
     <"#id" and > - div with an id
     <"class" and > - div with a class
     <"#id.class" and > - div with an id and class
     */
    /*oTable = jQuery('#data_table').DataTable({
     //         dom: 'T<"clear">lfrtip',
     fixedHeader: true,
     aaSorting: [],
     bPaginate: true,
     bLengthChange: true,
     bInfo: true,
     bAutoWidth: false,
     bFilter: true,
     iDisplayLength: 25,
     sDom: 'T<"clear">lfrtip',
     oTableTools: {
     aButtons: [
     "print",
     {
     sExtends: "collection",
     sButtonText: "Save",
     aButtons: ["csv", "xls"]
     }
     ]
     },
     tableTools: {
     "sSwfPath": "http://cdn.datatables.net/tabletools/2.2.2/swf/copy_csv_xls_pdf.swf"
     },
     processing: false,
     serverSide: false,
     });*/
    /***************************** End Common scripts ****************************/
    /************************* Form event submit scripts *************************/
    jQuery("#event_form").submit(function () {
//        var event_type_ids = jQuery(this).find('input[name=event_type_ids\\[\\]]');
//        var event_type_ids_selected = jQuery(this).find('input[name=event_type_ids\\[\\]]:checked').length;

        var date = jQuery(this).find('input[name=event_date]').val();
        var location = jQuery(this).find('input[name=event_location]').val();
        var orgnizer = jQuery(this).find('input[name=organizer_id]:checked').val();
//        var event_type = jQuery(this).find('input[name=event_type]:checked').val();

        var vaildate = true;
//        if (event_type_ids_selected <= 0) {
//            jQuery(event_type_ids).closest('div .form-group').addClass('has-error');
//            jQuery('#event_type_ids_message').html('Atleast one is required.');
//            vaildate = false;
//        } else {
//            jQuery(event_type_ids).closest('div .form-group').removeClass('has-error');
//            jQuery('#event_type_ids_message').html('');
//        }

        if (date === '') {
            jQuery(this).find('input[name=event_date]').closest('div .form-group').addClass('has-error');
            jQuery('#event_date_message').html('Date is required.');
            vaildate = false;
        } else {
            jQuery(this).find('input[name=event_date]').closest('div .form-group').removeClass('has-error');
            jQuery('#event_date_message').html('');
        }
        if (location === '') {
            jQuery(this).find('input[name=event_location]').closest('div .form-group').addClass('has-error');
            jQuery('#event_location_message').html('Location is required.');
            vaildate = false;
        } else {
            jQuery(this).find('input[name=event_location]').closest('div .form-group').removeClass('has-error');
            jQuery('#event_location_message').html('');
        }
        if (!orgnizer) {
            jQuery(this).find('input[name=organizer_id]').closest('div .form-group').addClass('has-error');
            jQuery('#organizer_id_message').html('The Organizer field is required.');
            vaildate = false;
        } else {
            jQuery(this).find('input[name=organizer_id]').closest('div .form-group').removeClass('has-error');
            jQuery('#organizer_id_message').html('');
        }
//        if (!event_type) {
//            jQuery(this).find('input[name=event_type]').closest('div .form-group').addClass('has-error');
//            jQuery('#event_type_message').html('The event type field is required.');
//            vaildate = false;
//        } else {
//            jQuery(this).find('input[name=event_type]').closest('div .form-group').removeClass('has-error');
//            jQuery('#event_type_message').html('');
//        }
        /* Orgnizational vaildation section */
        if (!vaildate_orgnization("#event_form")) {
            vaildate = false;
        }
        /* End Orgnizational vaildation section */

        return vaildate;
    });
    jQuery("#create_attendance_form").submit(function () {
        var organizer_id = jQuery(this).find('input[name=organizer_id]').val();
        var seminar_id = jQuery(this).find('input[name=seminar_id]').val();
        var event_id = jQuery(this).find('input[name=event_id]').val();
        var event_city_id = jQuery(this).find('input[name=event_city_id]').val();
        var event_zone_id = jQuery(this).find('input[name=event_zone_id]').val();

        var button = jQuery(this).find('button[type=submit]');
        var message = jQuery('#create_attendance_message');
        message.html('');
        message.removeClass();
        button.attr('disabled', 'disabled');
        message.addClass('alert alert-info');
        message.html('<i class="icon fa fa-info"></i> Please Wait. Creating attendance sheet.');
        jQuery.ajax({
            type: 'post',
            url: site_base_url + 'create_attendance_sheet',
            cache: false,
            data: {
                event_id: event_id,
                organizer_id: organizer_id,
                seminar_id: seminar_id,
                event_city_id: event_city_id,
                event_zone_id: event_zone_id
            },
            success: function (json) {
                button.remove();
                message.removeClass();
                message.html('');
                var response = jQuery.parseJSON(json);
                if (response.status === true) {
                    message.addClass('alert alert-success');
                    message.html('<i class="icon fa fa-check"></i>' + response.message);
                } else {
                    message.addClass('alert alert-danger');
                    message.html('<i class="icon fa fa-ban"></i>' + response.message);
                }
            }
        });
        return false;
    });
    jQuery("#export_participants").submit(function () {
        var submit = true;
        var columns = jQuery(this).find('input[name=exportcolumns\\[\\]]');
        var columns_selected = jQuery(this).find('input[name=exportcolumns\\[\\]]:checked').length;
        var ideologies = jQuery(this).find('input[name=ideologies\\[\\]]');
        var ideologies_selected = jQuery(this).find('input[name=ideologies\\[\\]]:checked').length;
        var propagation = jQuery(this).find('input[name=propagation\\[\\]]');
        var propagation_selected = jQuery(this).find('input[name=propagation\\[\\]]:checked').length;

        /* Columns vaildation section */
        if (columns_selected > 0) {
            jQuery(columns).closest('.form-group').children('.error_message').remove();
            jQuery(columns).closest('.form-group').removeClass('has-error');
        } else {
            submit = false;
            jQuery(columns).closest('.form-group').addClass('has-error');
            if (!jQuery(columns).closest('.form-group').children().hasClass('error_message')) {
                jQuery(columns).closest('.form-group').append('<label class="col-sm-12 control-label to-left error_message">Atleast one option is required.</lable>');
            }
        }
        /* End Columns vaildation section */
        /* Ideologies vaildation section */
        if (ideologies_selected > 0) {
            jQuery(ideologies).closest('.form-group').children('.error_message').remove();
            jQuery(ideologies).closest('.form-group').removeClass('has-error');
        } else {
            submit = false;
            jQuery(ideologies).closest('.form-group').addClass('has-error');
            if (!jQuery(ideologies).closest('.form-group').children().hasClass('error_message')) {
                jQuery(ideologies).closest('.form-group').append('<label class="col-sm-12 control-label to-left error_message">Atleast one option is required.</lable>');
            }
        }
        /* End Ideologies vaildation section */
        /* Propagation vaildation section */
        if (propagation_selected > 0) {
            jQuery(propagation).closest('.form-group').children('.error_message').remove();
            jQuery(propagation).closest('.form-group').removeClass('has-error');
        } else {
            submit = false;
            jQuery(propagation).closest('.form-group').addClass('has-error');
            if (!jQuery(propagation).closest('.form-group').children().hasClass('error_message')) {
                jQuery(propagation).closest('.form-group').append('<label class="col-sm-12 control-label to-left error_message">Atleast one option is required.</lable>');
            }
        }
        /* End Propagation vaildation section */
        /* Orgnizational vaildation section */
        if (!vaildate_orgnization("#export_participants")) {
            submit = false;
        }
        /* End Orgnizational vaildation section */
        return submit;
    });
    /*********************** End Form event submit scripts ***********************/

    /************************* Form event change scripts *************************/
    jQuery("#event_seminar_name").change(function () {
        var seminar_id = jQuery(this).val();
        if (seminar_id === '1') {
            jQuery('#event_seminar_title').removeAttr('disabled');
        } else {
            jQuery('#event_seminar_title').attr('disabled', 'disabled');
        }
    });

    jQuery("#zone_organization").change(function () {
        var zone_id = jQuery(this).val();
        jQuery.ajax({
            type: 'post',
            url: site_base_url + 'organization/get_below_organization',
            cache: false,
            data: {
                id: zone_id,
                level: 'zone'
            },
            success: function (json) {
                var response = jQuery.parseJSON(json);
                if (response.status === true) {
                    jQuery("#city_organization").html(response.city_list);
                    jQuery("#city_organization").change();
                } else {
                    jQuery("#zone_organization").parent().parent().addClass('has-error');
                }
            }
        });
    });
    jQuery("#city_organization").change(function () {
        var city_id = jQuery(this).val();
        jQuery.ajax({
            type: 'post',
            url: site_base_url + 'organization/get_below_organization',
            cache: false,
            data: {
                id: city_id,
                level: 'city'
            },
            success: function (json) {
                var response = jQuery.parseJSON(json);
                if (response.status === true) {
                    jQuery("#halqa_organization").html(response.halqa_list);
//                    jQuery("#halqa_organization").change();
                } else {
                    jQuery("#city_organization").parent().parent().addClass('has-error');
                }
            }
        });
    });
    jQuery("#group_calculator").change(function () {
        var no_of_groups = jQuery(this).val();
        var total_articipants = jQuery(this).attr('max');
        if (no_of_groups > 0) {
            var average = Math.round(total_articipants / no_of_groups);
//            alert('no of groups:' + no_of_groups + 'and max:' + total_articipants);
            jQuery('#group_calculator_message').html('Average participant(s) in ' + no_of_groups + ' group(s): ' + average);
        }
    });

    /*********************** End Form event change scripts ***********************/

    /************************* Form event click scripts **************************/
    jQuery('a[data-confirm]').click(function (ev) {
        var href = jQuery(this).attr('href');
        if (!jQuery('#dataConfirmModal').length) {
            return true;
        }
        jQuery('#dataConfirmModal').find('.modal-body').text(jQuery(this).attr('data-confirm'));
        jQuery('#dataConfirmOK').attr('href', href);
        jQuery('#dataConfirmModal').modal({show: true});
        return false;
    });
    jQuery("#print_summary").click(function () {
        var headContent = document.getElementsByTagName('head')[0].innerHTML;
        var divContents = jQuery("#print_section .tab-content .active").html();
        var printWindow = window.open('', '', 'height=400,width=800');
        printWindow.document.open();
        printWindow.document.write('<html><head><title>Zonel Seminar</title>');
        printWindow.document.write(headContent);
        printWindow.document.write('</head><body class="printing_tabs">');
        printWindow.document.write(divContents);
        printWindow.document.write('</body></html>');
        var is_chrome = Boolean(printWindow.chrome);
        if (is_chrome) {
            setTimeout(function () { // wait until all resources loaded
                printWindow.document.close(); // necessary for IE >= 10
                printWindow.focus(); // necessary for IE >= 10
                printWindow.print(); // change window to winPrint
                printWindow.close(); // change window to winPrint
            }, 250);
        } else {
            printWindow.document.close(); // necessary for IE >= 10
            printWindow.focus(); // necessary for IE >= 10

            printWindow.print();
            printWindow.close();
        }

    });
    jQuery("#print_badges_btn").click(function () {
        var headContent = document.getElementsByTagName('head')[0].innerHTML;
        var divContents = jQuery("#print_badges").html();
        var printWindow = window.open('', '', 'height=400,width=800');
        printWindow.document.open();
        printWindow.document.write('<html><head><title>Badges</title>');
        printWindow.document.write(headContent);
        printWindow.document.write('</head><body class="badges_print_page">');
        printWindow.document.write(divContents);
        printWindow.document.write('</body></html>');

        var is_chrome = Boolean(printWindow.chrome);
        if (is_chrome) {
            setTimeout(function () { // wait until all resources loaded
                printWindow.document.close(); // necessary for IE >= 10
                printWindow.focus(); // necessary for IE >= 10
                printWindow.print(); // change window to winPrint
                printWindow.close(); // change window to winPrint
            }, 250);
        } else {
            printWindow.document.close(); // necessary for IE >= 10
            printWindow.focus(); // necessary for IE >= 10

            printWindow.print();
            printWindow.close();
        }
    });
    /*********************** End Form event click scripts ************************/


    /************************* Other Form event scripts **************************/
    jQuery('.custom_ids').keydown(function (event) {
        var allow_comma = true;
        var string = jQuery(this).val();
        if (string.charAt(string.length - 1) === ',') {
            allow_comma = false;
        }
        // Allow only backspace and delete
        if (event.keyCode == 46 || event.keyCode == 8 || (event.keyCode == 188 && allow_comma == true)) {
            // let it happen, don't do anything
        }
        else {
            // Ensure that it is a number and stop the keypress
            if (event.keyCode < 35 || event.keyCode > 57) {
                event.preventDefault();
            }
        }
    });
    jQuery(".move-list").sortable({
        placeholder: "sort-highlight",
        handle: ".handle",
        forcePlaceholderSize: true,
        zIndex: 999999
    });
    /*********************** End Other Form event scripts ************************/
});

/* ajax functions */
function update_registration(registration_id, registration_status) {
    jQuery.ajax({
        type: 'post',
        url: site_base_url + 'registration/update_registration_status',
        cache: false,
        data: {
            registration_id: registration_id,
            registration_status: registration_status
        },
        success: function (json) {
            var response = jQuery.parseJSON(json);
            if (response.status === true) {
                var registration_percntage = parseFloat((response.present / response.total) * 100).toFixed(2);
                jQuery('#attendance_box h3').html(response.present + ' / ' + response.total);
                jQuery('#attendance_box h4').html(registration_percntage + ' %');
                jQuery('#registration_row_' + registration_id + ' .btn-attendance.btn-sm').attr('disabled', 'disabled');
                jQuery('#registration_row_' + registration_id + ' .btn-attendance.btn-sm').toggleClass('active');
                jQuery('#registration_row_' + registration_id + ' .btn-attendance.btn-sm.active').removeAttr('disabled');
                jQuery('#registration_row_' + registration_id + ' .time').html(response.time);
            } else {

            }
        }
    });
}
function update_registration_leave(registration_id, leave_status) {
    jQuery.ajax({
        type: 'post',
        url: site_base_url + 'registration/update_registration_on_leave',
        cache: false,
        data: {
            registration_id: registration_id,
            on_leave: leave_status
        },
        success: function (json) {
            var response = jQuery.parseJSON(json);
            if (response.status === true) {
                var attendance_percntage = parseFloat((response.present / response.total) * 100).toFixed(2);
                jQuery('#attendance_box h3').html(response.present + ' / ' + response.total);
                jQuery('#attendance_box h4').html(attendance_percntage + ' %');
                jQuery('#registration_row_' + registration_id + ' .btn-leave.btn-sm').attr('disabled', 'disabled');
                jQuery('#registration_row_' + registration_id + ' .btn-leave.btn-sm').toggleClass('active');
                jQuery('#registration_row_' + registration_id + ' .btn-leave.btn-sm.active').removeAttr('disabled');
                if (leave_status == '1') {
                    jQuery('#registration_row_' + registration_id + ' .time').html('On Leave');
                    jQuery('#registration_row_' + registration_id + ' .btn-attendance.btn-sm').attr('disabled', 'disabled');
                } else {
                    jQuery('#registration_row_' + registration_id + ' .btn-attendance.btn-sm.active').removeAttr('disabled');
                    jQuery('#registration_row_' + registration_id + ' .time').html(response.time);
                }
            } else {

            }
        }

    });
}
function get_selected_event_type(event_type) {
    jQuery('#event_type_ids').html('<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>');
    jQuery.ajax({
        type: 'post',
        url: site_base_url + 'event/get_selected_event_type',
        cache: false,
        data: {
            event_type: event_type
        },
        success: function (json) {
            var response = jQuery.parseJSON(json);
            if (response.status === true) {
                jQuery('#event_type_ids').html(response.data);
                load_event_with_icheck();
            } else {
                jQuery('#event_type_ids').html('Got some error. Reload Page and try again.');
            }
        }

    });
}
function get_cities_in_selected_zones(zones) {
    jQuery('#custom_city').html('<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>');
    jQuery.ajax({
        type: 'post',
        url: site_base_url + 'organization/get_cities_in_zones',
        cache: false,
        data: {
            zones: zones
        },
        success: function (json) {
            var response = jQuery.parseJSON(json);
            console.log(response);
            if (response.status === true) {
                jQuery('#custom_city').html(response.data);
                load_event_with_icheck();
            } else {
                jQuery('#custom_city').html('Got some error. Reload Page and try again.');
            }
        }

    });
}
function get_halqas_in_selected_cities(cities) {
    jQuery('#custom_halqa').html('<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>');
    jQuery.ajax({
        type: 'post',
        url: site_base_url + 'organization/get_halqas_in_cities',
        cache: false,
        data: {
            cities: cities
        },
        success: function (json) {
            var response = jQuery.parseJSON(json);
            console.log(response);
            if (response.status === true) {
                jQuery('#custom_halqa').html(response.data);
                load_event_with_icheck();
            } else {
                jQuery('#custom_halqa').html('Got some error. Reload Page and try again.');
            }
        }

    });
}

/* End ajax functions */

/* Common use functions */
function validateEmail(email) {
    var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
    return re.test(email);

}
function vaildate_orgnization(form_id) {
    var vaildate = true;
    var zone = jQuery(form_id).find('input[name=zone]:checked').val();
    if (zone === 'custom') { //Check for limited zone
        /* Zone vaildation section */
        var custom_zone = jQuery(form_id).find('input[name=custom_zone\\[\\]]');
        var zones_selected = jQuery(form_id).find('input[name=custom_zone\\[\\]]:checked').length;
        if (zones_selected > 0) {
            jQuery(custom_zone).closest('.form-group').children('.error_message').remove();
            jQuery(custom_zone).closest('.form-group').removeClass('has-error');
            var city = jQuery(form_id).find('input[name=city]:checked').val();
            if (city === 'custom') { //Check for limited city
                /* City vaildation section */
                var custom_city = jQuery(form_id).find('input[name=custom_city\\[\\]]');
                var cities_selected = jQuery(form_id).find('input[name=custom_city\\[\\]]:checked').length;

                if (cities_selected > 0) {
                    jQuery(custom_city).closest('.form-group').children('.error_message').remove();
                    jQuery(custom_city).closest('.form-group').removeClass('has-error');
                    var halqa = jQuery(form_id).find('input[name=halqa]:checked').val();
                    if (halqa === 'custom') { //Check for limited halqa
                        /* Halqa vaildation section */
                        var custom_halqa = jQuery(form_id).find('input[name=custom_halqa\\[\\]]');
                        var halqas_selected = jQuery(form_id).find('input[name=custom_halqa\\[\\]]:checked').length;
                        if (halqas_selected > 0) {
                            jQuery(custom_halqa).closest('.form-group').children('.error_message').remove();
                            jQuery(custom_halqa).closest('.form-group').removeClass('has-error');

                        } else {
                            vaildate = false;
                            jQuery(custom_halqa).closest('.form-group').addClass('has-error');
                            if (!jQuery(custom_halqa).closest('.form-group').children().hasClass('error_message')) {
                                jQuery(custom_halqa).closest('.form-group').append('<label class="col-sm-12 to-left error_message">Atleast one option is required.</lable>');
                            }
                        }
                        /* End Halqa vaildation section */
                    }
                } else {
                    vaildate = false;
                    jQuery(custom_city).closest('.form-group').addClass('has-error');
                    if (!jQuery(custom_city).closest('.form-group').children().hasClass('error_message')) {
                        jQuery(custom_city).closest('.form-group').append('<label class="col-sm-12 to-left error_message">Atleast one option is required.</lable>');
                    }
                }
            }
        } else {
            vaildate = false;
            jQuery(custom_zone).closest('.form-group').addClass('has-error');
            if (!jQuery(custom_zone).closest('.form-group').children().hasClass('error_message')) {
                jQuery(custom_zone).closest('.form-group').append('<label class="col-sm-12 to-left error_message">Atleast one option is required.</lable>');
            }
        }
        /* End Zone vaildation section */
    }
    return vaildate;
}
function load_event_with_icheck() {
    jQuery('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    });
    jQuery("input[name=badge_for]").on('ifChecked change', function () {
        var badge_for = jQuery(this).val();
        if (badge_for === 'custom') {
            jQuery("#custom_ids").removeClass('hidden');
        } else if (!jQuery("#custom_ids").hasClass('hidden')) {
            jQuery("#custom_ids").addClass('hidden');
        }
    });

    jQuery("#export_participants input[name=event_type],#event_form input[name=event_type]").on('ifChecked change', function () {
        get_selected_event_type(jQuery(this).val());
    });

    jQuery("#export_participants input[name=zone],#event_form input[name=zone]").on('ifChecked change', function () {
        var option = jQuery(this).val();
        if (option === 'custom' && jQuery('#custom_zone').hasClass('hidden')) {
            jQuery('#custom_zone').removeClass('hidden');
        } else if (option === 'all') {
            jQuery('#custom_zone').addClass('hidden');
            jQuery('#zone_area input[name=custom_zone\\[\\]]').iCheck('uncheck');
            jQuery('#city_area input[name=city]').iCheck('check');
            jQuery('#city_area').addClass('hidden');
        }
    });
    jQuery("#export_participants input[name=custom_zone\\[\\]],#event_form input[name=custom_zone\\[\\]]").on('ifChanged change', function () {
        var options = jQuery("input[name=custom_zone\\[\\]]");
        var custom_zone = [];
        for (i = 0; i < options.length; i++) {
            if (options[i].checked) {
                custom_zone.push(options[i].value);
            }
        }
        if (custom_zone.length > 0) {
            jQuery(options).closest('.form-group').children('.error_message').remove();
            jQuery(options).closest('.form-group').removeClass('has-error');
            jQuery('#city_area').removeClass('hidden');
            get_cities_in_selected_zones(custom_zone);
        } else {
            jQuery('#city_area').addClass('hidden');
        }
        jQuery('#halqa_area').addClass('hidden');
    });
    jQuery("#export_participants input[name=city],#event_form input[name=city]").on('ifChanged change', function () {
        var option = jQuery(this).val();
        if (option === 'custom' && jQuery('#custom_city').hasClass('hidden')) {
            jQuery('#custom_city').removeClass('hidden');
        } else if (option === 'all') {
            jQuery('#custom_city').addClass('hidden');
            jQuery('#city_area input[name=custom_city\\[\\]]').iCheck('uncheck');
            jQuery('#halqa_area input[name=halqa]').iCheck('check');
            jQuery('#halqa_area').addClass('hidden');

        }
    });
    jQuery("#export_participants input[name=custom_city\\[\\]],#event_form input[name=custom_city\\[\\]]").on('ifChanged change', function () {
        var options = jQuery("input[name=custom_city\\[\\]]");
        var custom_city = [];
        for (i = 0; i < options.length; i++) {
            if (options[i].checked) {
                custom_city.push(options[i].value);
            }
        }
        if (custom_city.length > 0) {
            jQuery(options).closest('.form-group').children('.error_message').remove();
            jQuery(options).closest('.form-group').removeClass('has-error');
            jQuery('#halqa_area').removeClass('hidden');
            get_halqas_in_selected_cities(custom_city);
        } else {
            jQuery('#halqa_area').addClass('hidden');
        }
    });
    jQuery("#export_participants input[name=halqa],#event_form input[name=halqa]").on('ifChecked change', function () {
        var option = jQuery(this).val();
        if (option === 'custom' && jQuery('#custom_halqa').hasClass('hidden')) {
            jQuery('#custom_halqa').removeClass('hidden');
        } else {
            jQuery('#custom_halqa').addClass('hidden');
            jQuery('#halqa_area input[name=custom_halqa\\[\\]]').iCheck('uncheck');
        }
    });
    jQuery("#export_participants input[name=custom_halqa\\[\\]],#event_form input[name=custom_halqa\\[\\]]").on('ifChanged change', function () {
        var options = jQuery("input[name=custom_halqa\\[\\]]");
        var halqas = jQuery("input[name=custom_halqa\\[\\]]:checked").length;
        if (halqas > 0) {
            jQuery(options).closest('.form-group').children('.error_message').remove();
            jQuery(options).closest('.form-group').removeClass('has-error');
        }
    });
    jQuery("#export_participants input[name=tabiat],#event_form input[name=tabiat]").on('ifChecked change', function () {
        var option = jQuery(this).val();
        if (option === 'all' && !jQuery('#tabiat_block').hasClass('hidden')) {
            jQuery('#tabiat_block').addClass('hidden');
        } else {
            jQuery('#tabiat_block').removeClass('hidden');
        }
    });
        jQuery("#export_participants input[name=dawat],#event_form input[name=dawat]").on('ifChecked change', function () {
        var option = jQuery(this).val();
        if (option === 'all' && !jQuery('#dawat_block').hasClass('hidden')) {
            jQuery('#dawat_block').addClass('hidden');
        } else {
            jQuery('#dawat_block').removeClass('hidden');
        }
    });
    jQuery("#event_form input[name=organizer]").on('ifChecked change', function () {
        jQuery("#organizers").html('<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>');
        var organization = jQuery(this).val();
        jQuery.ajax({
            type: 'post',
            url: site_base_url + 'organization/get_event_organizers',
            cache: false,
            data: {
                organization: organization,
            },
            success: function (json) {
                var response = jQuery.parseJSON(json);
                if (response.status === true) {
                    jQuery("#organizers").html(response.organizers);
                    load_event_with_icheck();
                } else {
                    jQuery("#organizers").html('<div class="form-group"><lable class="control-label">Error found. Reload page and try again.</lable></div>');
                }
            }
        });
    });
}
/* End Common use functions */