var formWorker = function () {
    var handlerGalleryItemActions = function () {
        $(document).on('click', '.remove-slider-img', function (e) {
            var thisclick = jQuery(this);
            var msg = "You are going to delete an slider image, are you sure?";

            if (confirm(msg)) {
                var fileid = thisclick.parents('.gallery-item').attr('qq-file-id');
                if (fileid) {
                    $('#fine-uploader-gallery').fineUploader('cancel', fileid);
                    thisclick.parents('.gallery-item').find('.qq-upload-cancel-selector,.qq-upload-delete-selector').click();
                }
                thisclick.parents('.gallery-item').remove();
            }
        });
        $(document).on('click', '.edit-slider-img', function (e) {
            var thisclick = jQuery(this);
            $('#overlay').show();
            thisclick.parents('.gallery-item').find('.js--media-actions').removeClass('hidden')
        });
        $(document).on('click', '#overlay,.js-dismiss-slider-edit', function (e) {
            var thisclick = jQuery(this);
            $('#overlay').hide();
            $('.js--media-actions:visible').addClass('hidden')
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

    function upload_filer() {
        $('#slider-images-dropzone').fineUploader({
            template: 'qq-template-gallery',
            listElement: $("#gallery-list"),
            request: {
                endpoint: cp_route_name + '/slider/upload/slider-gallery',
                params: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                },
            },
            thumbnails: {
                placeholders: {
                    waitingPath: 'cp/plugins/fineuploader/placeholders/waiting-generic.png',
                    notAvailablePath: 'cp/plugins/fineuploader/placeholders/not_available-generic.png'
                }
            },
            validation: {
                allowedExtensions: ['jpeg', 'jpg', 'gif', 'png', 'webp'],
                sizeLimit: 20971520
            },
            chunking: {
                enabled: false,
                partSize: 1000000,
                concurrent: {
                    enabled: true
                },
                success: {
                    endpoint: "../includes/fineuploader/endpoint.php?done=true"
                }
            },
            resume: {
                enabled: true
            },
        })
            .on('progress', function (event, id, name, responseJSON) {
                flaguploading = true;
            })
            .on('totalProgress', function (event, totalUploadedBytes, totalBytes) {
                if (totalUploadedBytes < totalBytes) {
                    progress = Math.round(totalUploadedBytes /
                        totalBytes * 100) + '%';
                    $('.tot_bar').css('width', progress);
                }
            })
            .on('cancel', function (event, id, name, responseJSON) {
                flaguploading = false;
            })
            .on('complete', function (event, id, name, responseJSON) {

                jQuery('.gallery-item[qq-file-id=' + id + ']')
                    .find('.hdnfile')
                    .val(responseJSON.file_name)
                    .attr('name', 'slider[' + name + '][fileName]');

                $('.gallery-item[qq-file-id=' + id + '] .js--media-actions [name]').each(function () {
                    let _name = $(this).attr('name');
                    $(this).attr('name', _name.replace('slider[]', 'slider[' + name + ']'));
                });

                jQuery('.gallery-item[qq-file-id=' + id + '] .slider_image_title').each(function () {
                    let lang = $(this).attr('lang');
                    $(this).attr('name', 'slider[' + name + '][title][' + lang + ']');
                });


            })
            .on('allComplete', function (event, id, name, responseJSON) {

                $('.tot_bar').css('width', '0');
                flaguploading = false;
                sort_media();
                var activeLanguageTab = $('.nav-lang > li.active > .language_switch ') ? $('.nav-lang > li.active > .language_switch ').attr('data-lang') : $('html').attr('lang');
                jQuery('.gallery-item[qq-file-id=' + id + ']').find('.switchable[data-lang]').each(function () {
                    if ($(this).attr('data-lang') === activeLanguageTab) {
                        $(this).removeClass('hidden')
                    } else {
                        $(this).addClass('hidden')
                    }
                });

            }).on('uploadChunkSuccess', function (event, id, chunkData, responseJSON) {
            jQuery('.gallery-item[qq-file-id=' + id + ']').find('.hdnfile').val(responseJSON.file_name);
            sort_media();

        });
    }

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
            stop: function () {
            }
        });

    }

    window.upload_filer = upload_filer;
    window.sort_media = sort_media;
    upload_filer();
    sort_media();

    function check_uploading() {
        return flaguploading;
    }

    window.check_uploading = check_uploading;

});
