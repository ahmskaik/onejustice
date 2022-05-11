var formWorker = function () {

    var avatar;

    var initForm = function () {
        avatar = new KTAvatar('kt_add_avatar');
        $('[data-switch=true]').bootstrapSwitch();

        /*  $('.myselect2').select2({
              placeholder: "Select Option",
              allowClear: true,
              width: 'resolve'
          });*/

        $('.myselect2').selectpicker();
    }
    var handleValidationForm = function () {
        jQuery('.form-nosubmit').on('keyup keypress', function (e) {
            var code = e.keyCode || e.which;
            if (code == 13) {
                e.preventDefault();
                return false;
            }
        });

        jQuery(document).on('submit', '#company-form', function (e) {
            var form = document.getElementById('company-form');
            var formAction = form.getAttribute('action');
            var formData = new FormData(form);
            var val = $("button[type=submit][clicked=true]").attr("name");


            var validation_result = handlePublishValidation();

            if (validation_result > 0) {
                Command: toastr["error"]("Number of errors " + validation_result + "", "Message");
                return false;
            }


            handleInformation(function (xhr) {
                var obj = xhr;// JSON.parse(xhr.responseText);
                if (xhr.status == 200) {

                    toastr.options.positionClass = "toast-top-right";
                    toastr.success(obj.message);

                    setTimeout(function () {
                        window.location.href = cp_route_name + "/" + obj.route;
                    }, 750);
                } else {
                    Command: toastr["error"](obj.errors, obj.message);
                }
            });


            return false;
        });
    };

    function handleInformation(callback) {
        var form = document.getElementById('product-form');
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

    var handleTagsInput = function () {
        var inputs = document.querySelectorAll('.tags-input');
        inputs.forEach(function (_input) {
            new Tagify(_input, {
                transformTag: transformTag,
            });
        });

        function transformTag(tagData) {
            var states = [
                'success',
                'brand',
                'danger',
                'success',
                'warning',
                'dark',
                'primary',
                'info'];

            tagData.class = 'tagify__tag tagify__tag--' + states[KTUtil.getRandomInt(0, 7)];

            if (tagData.value.toLowerCase() == 'test') {
                tagData.value = 'test'
            }
        }
    };
    return {
        init: function () {
            initForm();
            handleValidationForm();
            handleTagsInput();
        }
    };
}();
jQuery(document).ready(function () {
    $('.datepicker-input').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        //  endDate: '0d'
    });
});
