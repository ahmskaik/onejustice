var flag = true;
jQuery(document).ready(function () {
    stickyInputs.init();

    handleSwitchLanguage();
    handleCounterup();
    jQuery(document).on("click", ".language_switch", function () {
        let language = $(this).attr('data-lang');
        let languageName = $(this).attr('data-lang-full');
        handleSwitchLanguage(language);
        if (!$(this).hasClass('js-muted-list')) {
            $('.nav-lang>li').removeClass('active');
            $('.language_switch').attr('class', 'btn btn-outline-secondary language_switch tab' + languageName).find('i').remove();
            $(this).attr('class', 'btn btn-outline-brand language_switch tab' + languageName).prepend('<i class="fa fa-check-circle"></i>').parent().addClass('active');
        }
    });

    jQuery(".avatar-file").on("change", function () {
        var image_holder = $(this).parent();
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

        if (/^image/.test(files[0].type)) { // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local filema

            reader.onloadend = function () { // set image data as background of div
                image_holder.css("background-image", "url(" + this.result + ")");
            }
        } else {
            jQuery(this).val("");
            alert("Please select just images");
        }
    });

    jQuery(document).on('submit', '.search-form', function () {
        return false;
    });
});
// Handles counterup plugin wrapper
var handleCounterup = function () {
    if (!$().counterUp) {
        return;
    }

    $("[data-counter='counterup']").counterUp({
        delay: 10,
        time: 1000
    });
};

function handleSwitchLanguage(lang) {
    if (!lang)
        lang = globals.locale;

    jQuery(".switchable[data-lang='" + lang + "']").not(".language_switch").removeClass('hidden');
    jQuery(".switchable[data-lang!='" + lang + "']").not(".language_switch").addClass('hidden');

}

window.handleSwitchLanguage = handleSwitchLanguage;


let stickyInputs = function () {
    let initTextInputs = function () {
        jQuery(document).on('click', '.lblinput', function () {
            //jQuery(this).addClass('lblinputtop');
            jQuery(this).parents('.input-wlbl').find('.form-control').eq(0).focus();
        });

        jQuery(document).on('focusin', '.input-wlbl', function () {
            jQuery(this).find('.lblinput').addClass('lblinputtop');
        });

        jQuery(document).on('focusout', '.input-wlbl', function () {
            if (jQuery(this).find('.form-control').val()) {
                jQuery(this).find('.lblinput').addClass('lblinputtop');
            } else {
                jQuery(this).find('.lblinput').removeClass('lblinputtop');
            }
        });

        jQuery(document).on('change', '.input-wlbl .form-control', function () {
            if (jQuery(this).val()) {
                jQuery(this).parents('.input-wlbl').find('.lblinput').addClass('lblinputtop');
            } else {
                if (!jQuery(this).is(':focus')) {
                    jQuery(this).parents('.input-wlbl').find('.lblinput').removeClass('lblinputtop');
                }
            }
        });
    };
    let initSelectInputs = function () {
        jQuery(document).on('click', '.select2-wlbl .lblselect', function () {
            jQuery(this).parents('.select2-wlbl').find('select.select2,select.myselect2,select.select2wlabel,select.selectcustom').select2("open");
        });

        jQuery('.select2-wlbl .lblselect').hover(function () {
            jQuery(this).parents('.select2-wlbl').find('.select2-container--default').addClass('select2-container--openmy');
        }, function () {
            jQuery(this).parents('.select2-wlbl').find('.select2-container--default').removeClass('select2-container--openmy');
        });

        jQuery(document).on('change', '.select2-wlbl select.select2,.select2-wlbl select.myselect2,select.select2wlabel,.select2-wlbl select.selectcustom', function () {
            jQuery(this).parents('.select2-wlbl').find('.lblselect').addClass('lblselecttop');
        });
    };
    return {
        init: function () {
            initTextInputs();
            initSelectInputs();
        }
    };
}();


function input_wlbl() {
    jQuery('.input-wlbl').each(function () {
        if (jQuery(this).find('.form-control').val()) {
            jQuery(this).find('.lblinput').addClass('lblinputtop');
        } else {
            jQuery(this).find('.lblinput').removeClass('lblinputtop');
        }
    });
}

window.input_wlbl = input_wlbl;
input_wlbl();

function select_wlbl() {
    jQuery('.select2-wlbl select,.selectbs-wlbl select').each(function () {
        //if(jQuery(this).find('option:selected').index()>0)
        if (jQuery(this).val()) {
            jQuery(this).parents('.select2-wlbl').find('.lblselect').addClass('lblselecttop');
            jQuery(this).parents('.selectbs-wlbl').find('.lblselect').addClass('lblselecttop');
        }
    });
};
window.select_wlbl = select_wlbl;
select_wlbl();
