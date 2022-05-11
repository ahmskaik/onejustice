var formWorker = function () {
    var default_language = globals.locale;
    var handleValidationForm = function () {
        jQuery('.form-nosubmit').on('keyup keypress', function (e) {
            var code = e.keyCode || e.which;
            if (code == 13) {
                e.preventDefault();
                return false;
            }
        });

        jQuery(document).on('submit', 'form', function (e) {
            // handlePublishValidation();

            if (handlePublishValidation() > 0) {
                e.preventDefault();
                return false;
            }
        });
    };
    var handleSave = function (route) {
        $('#save-close-btn').click(function (e) {
            e.preventDefault();
            var validation_result = handlePublishValidation();
            if (validation_result > 0) {
                Command: toastr["error"]("Number of errors " + validation_result + "", "Message");
                return false;
            }

            handleInformation(function (xhr) {
                if (xhr.flag) {
                    toastr.options.positionClass = "toast-top-right";
                    toastr.success(xhr.message);

                    setTimeout(function () {
                        window.location.href = cp_route_name + "/" + route;
                    }, 750);
                } else {
                    toastr.options.positionClass = "toast-top-right";
                    toastr.error(xhr.message);
                }
            });
        });

        $('#save-new-btn').click(function (e) {
            e.preventDefault();


            if (handlePublishValidation() > 0) {
                Command: toastr["error"]("Number of erros " + number_error + "", "Message");
                return false;
            }
            handleInformation(function (xhr) {
                if (xhr.flag) {

                    toastr.options.positionClass = "toast-top-right";
                    toastr.success(xhr.message);

                    setTimeout(function () {
                        window.location.href = cp_route_name + "/" + route + "/create";
                    }, 750);
                } else {
                    var xhr = JSON.parse(xhr);
                    toastr.options.positionClass = "toast-top-right";
                    toastr.error(xhr.message);
                }
            });
        });
    };

    function handleInformation(callback) {
        /*    var form = document.getElementById('category-form');
            var formAction = form.getAttribute('action');
            var formData = new FormData(form);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', formAction, true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    return callback(xhr);
                }
            };
            xhr.send(formData);*/

        var form = document.getElementById('category-form');
        var formAction = form.getAttribute('action');
        var formData = new FormData(form);

        jQuery.ajax({
            type: 'POST',
            url: formAction,
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
                KTApp.unblockPage();
                return callback(data);

            },
            error: function (data) {
                KTApp.unblockPage();
                return callback(data);
            }
        });
    }

    var handleImageUpload = function () {
        jQuery(".uploadfile-thumb").on("change", function () {
            var image_holder = $(this).parent();
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support

            if (/^image/.test(files[0].type)) { // only image file
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file

                reader.onloadend = function () { // set image data as background of div
                    image_holder.css("background-image", "url(" + this.result + ")");
                }
            } else {
                jQuery(this).val("");
                alert("Please select just images");
            }
        });
    };
    return {
        init: function (route) {
            handleSave(route);
            handleValidationForm();
            handleImageUpload();
        }
    };

}();


jQuery(document).ready(function () {

});
