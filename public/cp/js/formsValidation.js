var urlreg = /^(http(s)?:\/\/)(www\.)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;
var errors;

jQuery(document).ready(function () {
    var default_language = globals.locale;

    function handlePublishValidation() {
        var numberEn = 0;
        var numberAr = 0;
        var number_error = 0;
        var InputErrors = false;

        jQuery('.checkbox-list-required').each(function () {

            if (jQuery(this).find(':checked').length) {
                jQuery(this).closest('.form-group').removeClass('has-error');
            } else {
                InputErrors = true;
                number_error++;
                jQuery(this).closest('.form-group').addClass('has-error');
            }
        });


        $.each(globals.languages, function (index, value) {
            jQuery('.forminput-required.switchable[data-lang="' + index + '"] .form-control').each(function () {
                if (!jQuery(this).val()) {
                    if (jQuery(this).closest('.input-wlbl').length) {
                        jQuery(this).closest('.input-wlbl').addClass('has-error');
                    } else {
                        jQuery(this).closest('.form-group').addClass('has-error sa9d8');
                    }
                    InputErrors = true;
                    number_error++;
                    jQuery('ul.nav-lang>li>a[data-lang="' + index + '"]').parent().addClass('tab-error');
                } else {
                    jQuery(this).closest('.form-group').removeClass('has-error');
                    jQuery(this).closest('.input-wlbl').removeClass('has-error');
                    jQuery('ul.nav-lang>li>a[data-lang="' + index + '"]').parent().removeClass('tab-error');
                }
            });
        });

        jQuery('.forminputsingle-required:visible').each(function () {
            if (!jQuery(this).val()) {
                jQuery(this).addClass('has-error');
                InputErrors = true;
                number_error++;
                numberEn++;
            } else {
                jQuery(this).removeClass('has-error');
            }
        });
        jQuery('.forminput-single-required .form-control').each(function () {

            if (!jQuery(this).val()) {
                jQuery(this).closest('.form-group').addClass('has-error');
                InputErrors = true;
                number_error++;
            } else {
                jQuery(this).closest('.form-group').removeClass('has-error');
            }
        });
        jQuery('.table-input-required').each(function () {
            if (!jQuery(this).val()) {
                jQuery(this).addClass('error-input');
                InputErrors = true;
                number_error++;
            } else {
                jQuery(this).removeClass('error-input');
            }
        });
        jQuery('.forminput-required-related-with-checkbox:visible').each(function () {

            var checkBoxName = jQuery(this).data('related-box');
            var checkboxItem = $("input[name='" + checkBoxName + "']");

            if (checkboxItem.prop("checked")) {

                if (!jQuery(this).val()) {
                    jQuery(this).addClass('has-error').focus();
                    InputErrors = true;
                    number_error++;
                    numberEn++;
                } else {
                    jQuery(this).removeClass('has-error');
                }
            } else {
                jQuery(this).removeClass('has-error');
            }

        });
        jQuery('.select2-required').each(function () {
            if (jQuery(this).val().length > 0) {
                jQuery(this).parents('.form-group').removeClass('has-error');
            } else {
                jQuery(this).parents('.form-group').addClass('has-error');
                errors = true;
                number_error++;
            }
        }).change(function () {
            if (jQuery(this).find('option:selected').val().length > 0) {
                jQuery(this).parents('.form-group').removeClass('has-error');
                jQuery(this).parent().find('.error-msg-validation').remove();
            }
        });

        jQuery('.txtinput-related').each(function () {

            var input_related = jQuery(this).attr('data-related');
            var input_related_val = jQuery(this).parents('form').find('input[name=' + input_related + ']').val();
            var this_input_val = jQuery(this).val();
            var this_input_placeholder = jQuery(this).parents('form').find('input[name=' + input_related + ']').attr('placeholder');
            var input_related_placeholder = jQuery(this).attr('placeholder');
            //if (jQuery(this).val().trim().length > 0) {
            if (input_related_val != this_input_val) {
                jQuery(this).addClass('error-required');
                jQuery(this).parent().addClass('has-error is-invalid');
                if (!jQuery(this).parent().find('.error-msg-validation').is(':visible')) {
                    jQuery(this).parent().append('<span class="error-msg-validation">' + input_related_placeholder + ' and ' + this_input_placeholder + ' not equal</span>');
                }
                if (errors == false || (jQuery(this).offset().top < top)) {
                    //top = jQuery(this).offset().top;
                    top = jQuery(this).offset().top;
                }
                errors = true;
                number_error++;
            } else {
                if (jQuery(this).val().trim().length > 0) {
                    jQuery(this).removeClass('error-required');
                    jQuery(this).parent().removeClass('has-error is-invalid');
                    jQuery(this).parent().find('.error-msg-validation').remove();
                }
            }
            //}
        });
        jQuery(document).on('keyup', '.txtinput-related', function () {
            var input_related = jQuery(this).attr('data-related');
            var input_related_val = jQuery(this).parents('form').find('input[name=' + input_related + ']').val();
            var this_input_val = jQuery(this).val();
            var this_input_placeholder = jQuery(this).parents('form').find('input[name=' + input_related + ']').attr('placeholder');
            var input_related_placeholder = jQuery(this).attr('placeholder');
            jQuery(this).parent().find('.success-msg-validation,.error-msg-validation').remove();
            if (input_related_val == this_input_val) {
                jQuery(this).parent().append('<span class="success-msg-validation">Identical Password</span>')
            }
            if (input_related_val != this_input_val) {
                jQuery(this).parent().find('.success-msg-validation,.error-msg-validation').remove();
                jQuery(this).parent().find('.error-msg-validation').remove();
                jQuery(this).parent().append('<span class="error-msg-validation">' + input_related_placeholder + ' and ' + this_input_placeholder + ' not equal</span>');
            } else {
                if (jQuery(this).val().trim().length > 0) {
                    jQuery(this).removeClass('error-required');
                    jQuery(this).parent().removeClass('has-error is-invalid');
                    jQuery(this).parent().find('.error-msg-validation').remove();
                }
            }
        });

        jQuery(document).on('keyup', '.myinput-password', function () {
            var this_input = jQuery(this);
            var txtinput_minlength_val = this_input.attr('data-minlength');
            var str = this_input.val();

            var input_related_val = jQuery(this).parents('form').find('.txtinput-related').val();
            var this_input_val = jQuery(this).val();
            var this_input_placeholder = jQuery(this).parents('form').find('.txtinput-related').attr('placeholder');
            var input_related_placeholder = jQuery(this).attr('placeholder');

            if ((this_input.val().trim().length > 0)) {
                if ((this_input.val().trim().length >= txtinput_minlength_val)) {
                    jQuery(this).removeClass('error-required');
                    jQuery(this).parent().removeClass('has-error is-invalid');
                    jQuery(this).parent().find('.error-msg-validation').remove();
                    if (jQuery(this).parents('form').find('.txtinput-related').val()) {
                        jQuery(this).parents('form').find('.txtinput-related').parent().find('.success-msg-validation,.error-msg-validation').remove();
                        jQuery(this).parents('form').find('.txtinput-related').parent().append('<span class="error-msg-validation">' + input_related_placeholder + ' and ' + this_input_placeholder + ' not equal</span>');
                    }
                } else {
                    jQuery(this).addClass('error-required');
                    jQuery(this).parent().addClass('has-error is-invalid');
                    jQuery(this).parent().find('.error-msg-validation').remove();
                    jQuery(this).parent().append('<span class="error-msg-validation">Please enter at least ' + txtinput_minlength_val + ' fields </span>');
                    errors = true;
                }
                if (input_related_val == this_input_val) {
                    jQuery(this).parents('form').find('.txtinput-related').parent().find('.success-msg-validation,.error-msg-validation').remove();
                    jQuery(this).parents('form').find('.txtinput-related').parent().append('<span class="success-msg-validation">Identical Password</span>')
                }
            }
        });


        jQuery('.formboxinner-valid:visible .fileimgsm-required').each(function () {
            if (!jQuery(this).val()) {
                jQuery(this).parents('.small-image').addClass('has-error');
                InputErrors = true;
                number_error++;
                numberEn++;
            } else {
                jQuery(this).parents('.small-image').removeClass('has-error');
            }
        });

        jQuery('select.select-required').each(function () {
            if (!jQuery(this).val()) {
                jQuery(this).parents('.form-group').addClass('has-error');
                InputErrors = true;
                number_error++;
                numberEn++;
            } else {
                jQuery(this).parents('.form-group').removeClass('has-error');
            }
        });

        jQuery('#hdn_imgcrop.fileimg-required2').each(function () {
            jQuery(this).parents('.uploadimage-crop-area').find('.help-block.error').remove();
            if ((jQuery(this).attr('data-edit') == "false")) {
                if (!jQuery(this).val()) {
                    InputErrors = true;
                    number_error++;
                    numberEn++;
                    jQuery(this).parents('.uploadimage-crop-rg').after('<span class="help-block error">The Image is required2</span>');
                }
            }
        });
         return number_error;
    };
    window.handlePublishValidation = handlePublishValidation;


    function handleDraftValidation() {
        var numberEn = 0;
        var number_error = 0;
        var InputErrors = false;

        jQuery('.inputdraft-required').each(function () {
            if (!jQuery(this).val()) {
                numberEn++;
                InputErrors = true;
                number_error++;
                jQuery(this).addClass('has-error');
            } else {
                jQuery(this).removeClass('has-error');
            }
        });

        jQuery('select.selectdraft-required').each(function () {
            if (!jQuery(this).val()) {
                jQuery(this).parents('.form-group').addClass('has-error');
                numberEn++;
                InputErrors = true;
                number_error++;
            } else {
                jQuery(this).parents('.form-group').removeClass('has-error');
            }
        });
        return number_error;
    };
    window.handleDraftValidation = handleDraftValidation;


    function handleInputsValid() {
        jQuery(document).on('change', 'select.select-required', function () {
            if (!jQuery(this).val()) {
                jQuery(this).parents('.form-group').addClass('has-error');
                InputErrors = true;
            } else {
                jQuery(this).parents('.form-group').removeClass('has-error');
            }
        });


        jQuery(document).on('keyup', '.forminput-required .form-control', function () {
            var self = jQuery(this);
            var lang = self.closest('.form-group').attr('data-lang');
            if ((self.val().trim().length >= 2)) {
                self.closest('.form-group').removeClass('has-error');
                jQuery('ul.nav-tabs>li>a[data-lang="' + lang + '"]').parent().removeClass('tab-error');
            } else {
                self.closest('.form-group').addClass('has-error');
                jQuery('ul.nav-tabs>li>a[data-lang="' + lang + '"]').parent().addClass('tab-error');
            }

        });

        jQuery(document).on('keyup', '.txtinput-required', function () {
            if ((jQuery(this).val().trim().length > 2)) {
                jQuery(this).removeClass('error-required required-field');
                jQuery(this).parent().removeClass('has-error is-invalid');
            } else {
                jQuery(this).addClass('error-required required-field');
                jQuery(this).parent().addClass('has-error is-invalid ');
            }
        });

        jQuery(document).on('change', '.fileimgsm-required', function () {
            if (jQuery(this).val()) {
                jQuery(this).parents('.small-image').removeClass('has-error');
            }
        });

        jQuery(document).on('keyup', '.txtinput-urlvalid', function () {
            if ((jQuery(this).val().trim().length >= 1) && urlreg.test(jQuery(this).val().trim()) == true) {
                jQuery(this).parents('.form-group').find('.help-block').remove();
            } else {
                if ((jQuery(this).val().trim().length >= 1)) {
                    jQuery(this).parents('.form-group').find('.help-block').remove();
                    jQuery(this).parents('.form-group').append('<span class="help-block error">Please enter valid URL</span>');
                } else {
                    jQuery(this).parents('.form-group').find('.help-block').remove();
                }
            }
        });
    };

    handleInputsValid();


    var number_error = 0;
    var emailreg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;

    jQuery(document).on('submit', '.form-validation', function () {
        errors = false;
        number_error = 0;
        jQuery(this).find('.txtinput-required:visible').each(function () {

            if (jQuery(this).val().length < 1) {
                jQuery(this).addClass('error-required required-field');
                jQuery(this).parent().addClass('has-error is-invalid');
                if (jQuery(this).hasClass('login-error')) {
                    jQuery(this).addClass('login-error-gen');
                }
                if (errors == false) {
                    top = jQuery(this).offset().top;
                }
                errors = true;
                number_error++;
            } else {
                jQuery(this).removeClass('error-required');
                jQuery(this).parent().removeClass('has-error is-invalid');
            }

        });

        jQuery(this).find('.txtinput-email').each(function() {

            if (jQuery(this).val().length > 0 && emailreg.test(jQuery(this).val()) == false) {

                jQuery(this).addClass('error-required');
                jQuery(this).parent().addClass('error-parent');
                if (!jQuery(this).parent().find('.error-msg-validation').is(':visible')) {
                    jQuery(this).parent().append('<span class="error-msg-validation">Please enter valid email</span>');
                }
                if (errors == false || (jQuery(this).offset().top < top)) {
                    top = jQuery(this).offset().top;
                }
                errors = true;
                number_error++;
            }
            else if(!jQuery(this).hasClass('required-field')){
                jQuery(this).removeClass('error-required');
                jQuery(this).parent().removeClass('error-parent');
                jQuery(this).parent().find('.error-msg-validation').remove();
            }
            else {
                jQuery(this).parent().find('.error-msg-validation').remove();
            }
        });

        jQuery(this).find('.txtinput-mobile').each(function () {
            var txtinput_minlength_val = jQuery(this).attr('data-minlength');
            var str = jQuery(this).val();
            if (jQuery(this).val().length < 1) {
                jQuery(this).addClass('error-required required-field');
                jQuery(this).parent().addClass('has-error is-invalid');
                if (errors == false) {
                    top = jQuery(this).offset().top;
                }
                errors = true;
                number_error++;
            } else {
                if ((jQuery(this).val().length >= 10) && (str.substring(0, 2) == '05')) {
                    jQuery(this).removeClass('error-required');
                    jQuery(this).parent().removeClass('has-error is-invalid');
                    jQuery(this).parent().find('.error-msg-validation').remove();
                    //jQuery(this).parent().find('[data-toggle="tooltip"]').tooltip('hide').remove();
                } else {
                    jQuery(this).addClass('error-required');
                    jQuery(this).parent().addClass('has-error is-invalid');
                    if (!jQuery(this).parent().find('.error-msg-validation').is(':visible')) {
                        jQuery(this).parent().append('<span class="error-msg-validation">Please enter at least ' + txtinput_minlength_val + ' fields </span>');
                    }
                    if (errors == false || (jQuery(this).offset().top < top)) {
                        top = jQuery(this).offset().top;
                    }
                    errors = true;
                    number_error++;
                }
            }
        });

        jQuery(this).find('.txtinput-minlength').each(function () {
            var txtinput_minlength_val = jQuery(this).attr('data-minlength');
            var str = jQuery(this).val();
            if ((jQuery(this).val().length > 0)) {
                if ((jQuery(this).val().length >= txtinput_minlength_val)) {
                    jQuery(this).removeClass('error-required');
                    jQuery(this).parent().removeClass('has-error is-invalid');
                    jQuery(this).parent().find('.error-msg-validation').remove();
                } else {
                    jQuery(this).addClass('error-required');
                    jQuery(this).parent().addClass('has-error is-invalid');
                    if (!jQuery(this).parent().find('.error-msg-validation').is(':visible')) {
                        jQuery(this).parent().append('<span class="error-msg-validation">Please enter at least ' + txtinput_minlength_val + ' fields </span>');
                    }
                    if (errors == false || (jQuery(this).offset().top < top)) {
                        top = jQuery(this).offset().top;
                    }
                    errors = true;
                    number_error++;
                }
            }
        });

        if (errors == true) {
            if (top) {
                jQuery('html,body').animate({scrollTop: top - 100}, 400);
                Command: toastr["error"]("Number of erros " + number_error + "", "Message");
            }
            return false;
        }
    });
});
