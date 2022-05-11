var UploadImage = function () {

    var handleImageUpload = function () {
        jQuery(".uploadfile-img").on("change", function () {
            var thisclick = jQuery(this);
            var html = '<span class="rem-imgicon rem-imgfile"><i class="fa fa-close"></i></span>';
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

            if (/^image/.test(files[0].type)) { // only image file
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file
                if ((files[0].size / 1024 / 1024) <= 4) {
                    reader.onloadend = function () { // set image data as background of div
                        thisclick.parents(".upload-image-rg").css("background-image", "url(" + this.result + ")");
                        thisclick.parents(".upload-image-rg").prepend(html);
                        thisclick.parents('.uploadimg-rg').find('.help-block').remove();
                    }
                }
                else {
                    thisclick.parents('.fileimg-upload').find('.help-block.error').remove();
                    thisclick.parents('.upload-image-rg').after('<span class="help-block error">Please Add Image less than 4MB</span>');
                }
            }
            else {
                alert("Choose Just Image");
            }
        });
    };

    var handleRemoveImage = function () {
        jQuery(document).on('click', '.rem-imgfile', function () {
            var thisclick = jQuery(this);
            var title = thisclick.parents(".upload-image-rg").find('.uploadfile-img').attr('data-title');
            bootbox.confirm("Are you sure?", function (result) {
                if (result == true) {
                    thisclick.parents(".upload-image-rg").find('.uploadfile-img').val('').removeClass('fileimg-required');

                    if (thisclick.parents(".upload-image-rg").find('.uploadfile-img').hasClass('file-notrequired') == false) {
                        thisclick.parents(".upload-image-rg").find('.uploadfile-img').addClass('fileimg-required');
                    }
                    thisclick.parents(".upload-image-rg").removeAttr('style');
                    thisclick.parents(".upload-image-rg").find('.deletedFlag').val('1');
                    thisclick.remove();
                    Command: toastr["success"](title + " Image Removed!", "Success");
                }
            });
        });
    };

    return {
        init: function () {
            handleImageUpload();
            handleRemoveImage();
        }
    };

}();

jQuery(document).ready(function () {
    UploadImage.init();
});