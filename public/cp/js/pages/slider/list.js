var formWorker = function () {
    var handlerGalleryItemActions = function () {
        $(document).on('click', '.edit-slider-img', function (e) {
            var thisclick = jQuery(this);
            $('#overlay').show();
            thisclick.parents('.gallery-item').find('.js--media-actions').removeClass('hidden')
        });
        $(document).on('click', '#overlay,.js-cancel-edit-slider-img', function (e) {
            var thisclick = jQuery(this);
            $('#overlay').hide();
            $('.js--media-actions:visible').addClass('hidden')
        });
        jQuery(document).on("click", ".btn-delete", function () {
            if (!jQuery(this).attr("disabled")) {
                var this_click = jQuery(this);

                swal.fire({
                    title: "Are you sure you want to Delete this item?",
                    html: "<span class='blind-alert round'>Caution: You can not undo this operation !!..</span>>",
                    type: 'info',
                    showCancelButton: true,
                    confirmButtonText: "Ok, I understand",
                    cancelButtonText: "Cancel",
                }).then(function (result) {
                    if (result.value) {
                        jQuery.ajax({
                            type: 'POST',
                            url: this_click.attr('data-url'),
                            dataType: 'json',
                            success: function (data) {
                                if (data.status) {
                                    this_click.parents('.gallery-item').remove();
                                    toastr.options.positionClass = "toast-bottom-right";
                                    toastr.success(data.message);
                                } else {
                                    toastr.options.positionClass = "toast-bottom-right";
                                    toastr.error(data.message);

                                }
                            }
                        });
                    }
                });

            }

            return false;
        });
    };
    return {
        init: function (route) {
            handlerGalleryItemActions();
        }
    };
}();
jQuery(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var flaguploading = false;


    function sort_media() {
        jQuery("#gallery-list").sortable({
            //containment: "parent",
            containment: ".slider-images-wrapper",
            connectWith: "#gallery-list",
            items: ".gallery-item",
            opacity: 0.8,
            handle: '.js-drag-image',
            coneHelperSize: true,
            tolerance: "pointer",
            forcePlaceholderSize: !0,
            helper: "clone",
            revert: 250, // animation in milliseconds

            cancel: ".cancel-move", // cancel dragging if portlet is in fullscreen mode
            start: function () {
            },
            stop: function (evt, ui) {
                jQuery.ajax({
                    type: 'GET',
                    url: ui.item.find('.js-drag-image').attr('data-url') + "/" + ui.item.index(),
                    dataType: 'json',
                    success: function (data) {
                        if (data.status) {
                            toastr.options.positionClass = "toast-bottom-right";
                            toastr.success(data.message);
                        } else {
                            toastr.options.positionClass = "toast-bottom-right";
                            toastr.error(data.message);

                        }
                    }
                });
            }
        });
    }

    sort_media();

    function check_uploading() {
        return flaguploading;
    }

    window.check_uploading = check_uploading;

});
