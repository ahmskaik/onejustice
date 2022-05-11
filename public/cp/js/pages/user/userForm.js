jQuery(document).ready(function () {
    $('[data-switch=true]').bootstrapSwitch();
    $('.myselect2').select2({
        placeholder: "Select a state"
    });

    $("#password_strength").pwstrength(
        {
            raisePower: 1.4,
            minChar: 8,
            verdicts: ["Weak", "Normal", "Medium", "Strong", "Very Strong"],
            scores: [17, 26, 40, 50, 60]
        }
    );
    jQuery(document).on("submit", ".user-form", function () {

        var this_click = jQuery(this);
        var formData = new FormData($(this)[0]);
        var val = $("button[type=submit][clicked=true]").attr("name");

        var validation_result = handlePublishValidation();
        if (validation_result > 0) {
            Command: toastr["error"]("Number of errors " + validation_result + "", "Message");
            return false;
        }

        if (flag) {
            flag = false;
            jQuery.ajax({
                type: 'POST',
                url: this_click.attr("action"),
                dataType: 'json',
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    KTApp.blockPage({
                        overlayColor: '#000000',
                        type: 'v2',
                        state: 'success',
                        message: 'Please wait...'
                    });
                },
                success: function (data) {
                    if (data.status) {

                        toastr.options.positionClass = "toast-top-right";
                        toastr.success(data.message);

                        setTimeout(function () {
                            if (val == "save_new") {
                                window.top.location = cp_route_name + "/user/create";
                            } else {
                                window.top.location = cp_route_name + "/user";
                            }
                        }, 750);
                    }
                },
                error: function (data) {
                    flag = true;
                    //console.log(data);
                    if (jQuery('body').hasClass('body-site') == false) {
                        KTApp.unblockPage();
                    }
                    console.log(data.responseJSON);
                    if (data.responseJSON.user_name != undefined) {
                        jQuery('.formvalid-username .error-msg-validation,.formvalid-username .help-block.error').remove();
                        jQuery('.formvalid-username').append('<span class="error-msg-validation">' + data.responseJSON.user_name + '</span>');
                    }
                    if (data.responseJSON.email != undefined) {
                        jQuery('.formvalid-email .error-msg-validation,.formvalid-email .help-block.error').remove();
                        jQuery('.formvalid-email').append('<span class="error-msg-validation">' + data.responseJSON.email + '</span>');
                    }
                    if (data.responseJSON.mobile != undefined) {
                        jQuery('.formvalid-mobile .error-msg-validation,.formvalid-mobile .help-block.error').remove();
                        jQuery('.formvalid-mobile').append('<span class="error-msg-validation">' + data.responseJSON.mobile + '</span>');
                    }
                }
            });
        }

        return false;
    });

    $("form button[type=submit]").click(function () {
        $("button[type=submit]", $(this).parents("form")).removeAttr("clicked");
        $(this).attr("clicked", "true");
    });

    $('.datepicker-maxtoday').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        endDate: '0d'
    });

    jQuery(document).on('blur', '.form-control[data-validation]', function () {
        var this_input = jQuery(this);
        var input_url = $("base").attr("href") + this_input.attr('data-validation');

        var input_name = this_input.attr('name');
        var input_val = this_input.val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        if (flag && (this_input.val())) {
            flag = false;
            jQuery.ajax({
                type: 'POST',
                data: {[input_name]: input_val},
                url: input_url,
                beforeSend: function () {
                    this_input.parent().addClass('kt-spinner kt-spinner--sm kt-spinner--success kt-spinner--right kt-spinner--input');
                },
                dataType: "json",
                success: function (data) {
                    this_input.parent().find('.error-msg-validation').remove();
                    this_input.parent().removeClass('kt-spinner kt-spinner--sm kt-spinner--success kt-spinner--right kt-spinner--input');

                    flag = true;
                    if (data.status == true) {
                        this_input.removeClass('myerror has-error');
                    } else {
                        this_input.addClass('myerror has-error');
                        if (data.message[input_name]) {
                            this_input.parent().append('<span class="error-msg-validation">' + data.message[input_name][0] + '</span>');
                        }
                    }
                },
                error: function (data) {
                    flag = true;
                }
            });
        }
    });


    jQuery(document).on('change', '.role-dropdown', function () {
        var thisclick = jQuery(this);
        var roleid = thisclick.val();

        if (roleid && flag) {
            flag = false;

            jQuery(".mycheckbox")
                .prop("checked", false)
                .removeAttr("checked")
                .parents("label")
                .removeClass("blue")
                .removeClass("green")
                .removeClass("red");

            jQuery.ajax({
                url: cp_route_name + "/user/actionRole/" + roleid,
                type: 'GET',
                dataType: "json",
                beforeSend: function () {
                    KTApp.block('.js-permissions-list',
                        {
                            overlayColor: '#000000',
                            type: 'v2',
                            state: 'success',
                            message: 'Please wait...'
                        });
                },
                success: function (data) {
                    flag = true;
                    KTApp.unblock('.js-permissions-list');

                    if (data.status) {
                        jQuery(".mycheckbox").each(function () {
                            if (inArray(jQuery(this).val(), data.result)) {
                                jQuery(this).prop("checked", true)
                                    .parents("label")
                                    .removeClass("blue red black green")
                                    .addClass("blue");
                            }
                        });
                    } else {
                        toastr.options.positionClass = "toast-top-right";
                        toastr.error('Check Error');
                    }
                },
                error: function (data) {
                    KTApp.unblock('.js-permissions-list');
                    toastr.options.positionClass = "toast-top-right";
                    toastr.error('Please Check Selected Role');
                },
            });
        }
    });

    initChangePasswordPopover();

    function inArray(needle, haystack) {
        var length = haystack.length;
        for (var i = 0; i < length; i++) {
            if (haystack[i] == needle) return true;
        }
        return false;
    }
});

let initChangePasswordPopover = function () {
    const form_html =
        '<div class="form-popover">\
            <div class="form-group input-wlbl">\
                <label class="lblinput">Password</label>\
                <input type="password" class="form-control input-password" data-placeholder="Password" />\
            </div>\
            <div class="form-group input-wlbl">\
                <label class="lblinput">Confirm Password</label>\
                <input type="password" class="form-control input-confirmpassword" data-related="input-password" data-placeholder="Confirm Password" />\
            </div>\
            <button type="button" class="btn green btn-savepass">Ok</button>\
        </div>';

    jQuery('.mypopover').popover({
        html: true,
        content: function () {
            return form_html;
        },
        sanitize: false,
        title: function () {
            return 'Change Password';
        },
        placement: "top"
    });

    jQuery(document).on('click', 'body', function (e) {
        var target = $(e.target);
        if (!$(e.target).is('.mypopover, .mypopover *,.popover, .popover *,.editable')) {
            $('.popover,.mypopover').popover('hide');
        }
    });

    jQuery(document).on('focus', '.input-password', function () {
        var html = '<span class="msg-password">Please Enter at least 6 fields</span>';
        jQuery('.msg-password').remove();
        jQuery(this).after(html);
    });

    jQuery(document).on('keyup', '.input-password', function () {
        if (jQuery(this).val()) {
            jQuery('.msg-password').hide();
        } else {
            jQuery('.msg-password').show();
        }
    });

    jQuery(document).on('focus', '.input-password', function () {
        if (jQuery(this).val()) {
            jQuery('.msg-password').hide();
        } else {
            jQuery('.msg-password').show();
        }
    });

    jQuery(document).on('click', '.btn-savepass', function () {
        var password = jQuery('.input-password').val().trim();
        var confirmpassword = jQuery('.input-confirmpassword').val().trim();
        var errors_pass = false;
        if (!jQuery('.input-password').val() || !jQuery('.input-confirmpassword').val()) {
            jQuery('.input-password').addClass('has-error');
            jQuery('.input-confirmpassword').addClass('has-error');
            errors_pass = true;
        } else if (jQuery('.input-password').val() || jQuery('.input-confirmpassword').val()) {
            if (jQuery('.input-password').val().trim().length >= 6) {
                jQuery('.input-password').removeClass('has-error');
            }
            if (jQuery('.input-confirmpassword').val().trim().length >= 6) {
                jQuery('.input-confirmpassword').removeClass('has-error');
            }

        } else if (jQuery('.input-password').val() && jQuery('.input-confirmpassword').val()) {
            errors_pass = false;
        }
        jQuery('.input-confirmpassword').each(function () {
            var input_related = jQuery(this).attr('data-related');
            var input_related_val = jQuery(this).parents('.form-popover').find('.' + input_related).val();
            var this_input_val = jQuery(this).val();
            var this_input_placeholder = jQuery(this).parents('.form-popover').find('.' + input_related).attr('data-placeholder');
            var input_related_placeholder = jQuery(this).attr('data-placeholder');
            if (input_related_val != this_input_val) {
                jQuery(this).parent().find('.error-msg-validation').remove();
                jQuery('.input-confirmpassword').addClass('has-error');
                jQuery(this).parent().append('<span class="error-msg-validation">' + input_related_placeholder + ' and ' + this_input_placeholder + ' not equal</span>');
                errors_pass = true;
            } else {
                if (jQuery(this).val().trim().length > 0) {
                    jQuery('.input-confirmpassword').removeClass('has-error');
                    jQuery(this).parent().find('.error-msg-validation').remove();
                    errors_pass = false;
                }
            }
        });
        if (errors_pass == false) {
            jQuery('.new-password').attr('value', password);
            jQuery('.new-confirmpassword').attr('value', confirmpassword);
            $('.popover').popover('hide');
        }
        return false;
    });

    jQuery(document).on('keyup', '.input-password,.input-confirmpassword', function () {
        if ((jQuery(this).val().trim().length >= 6)) {
            jQuery(this).removeClass('has-error');
        } else {
            jQuery(this).addClass('has-error');
        }
    });

    jQuery(document).on('keyup', '.input-confirmpassword', function () {
        var input_related = jQuery(this).attr('data-related');
        var input_related_val = jQuery(this).parents('.form-popover').find('.' + input_related).val().trim();
        var this_input_val = jQuery(this).val().trim();
        if ((jQuery(this).val().trim().length >= 6) && (input_related_val == this_input_val)) {
            jQuery('.input-confirmpassword').removeClass('has-error');
            jQuery(this).parent().find('.error-msg-validation').remove();
        }
    });

};
