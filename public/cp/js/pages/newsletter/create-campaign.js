
var createCampaign = function () {

    var handleSwitchMessageType = function() {
        if(jQuery('.change-switchtype').prop('checked')==true)
        {
            jQuery('.urlmessage-region').removeClass('kt-hidden');
            jQuery('.htmlmessage-region').addClass('kt-hidden');
        }
        else
        {
            jQuery('.urlmessage-region').addClass('kt-hidden');
            jQuery('.htmlmessage-region').removeClass('kt-hidden');
        }
        jQuery('.change-switchtype').on('switchChange.bootstrapSwitch', function (event, state) {
            if(state==true)
            {
                jQuery('.urlmessage-region').removeClass('kt-hidden');
                jQuery('.htmlmessage-region').addClass('kt-hidden');
            }
            else
            {
                jQuery('.urlmessage-region').addClass('kt-hidden');
                jQuery('.htmlmessage-region').removeClass('kt-hidden');
            }
        });
    };

    var handleBtnMessagePreview = function() {
        jQuery(document).on('click','.btn-messagepreview',function() {
            var urlreg = /^(http(s)?:\/\/)(www\.)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/;
            if(jQuery('.urlmessage-region').is(':visible'))
            {
                var message_val = jQuery('.inputmessage-url').val();
                if(message_val && urlreg.test(message_val.trim()) == true)
                {
                    window.open(message_val,"_blank");
                }
                else
                {
                    Command: toastr["error"]("The URL is empty or not valid", "Error");
                }
            }
            else
            {
                var this_editor = jQuery('.htmlmessage-region textarea.tinymce').attr('id');
                var tinymce_editor = tinyMCE.get(this_editor).getContent().trim();
                jQuery('.modal-viewdetails .modal-body').html('').append(tinymce_editor);
                jQuery('#modal-viewdetails').modal('show');
            }
        });
    };

    return {
        init: function () {
            handleSwitchMessageType();
            handleBtnMessagePreview();
        }
    };

}();

jQuery(document).ready(function() {
    createCampaign.init();

    jQuery(document).on("form","submit",function(){
        var this_editor = jQuery(".tinymce").attr('id');
        var tinymce_length = tinyMCE.get(this_editor).getContent().trim().length;
        if(tinymce_length<=61){
            jQuery(".tinymce").val("");
        }
    });
});
