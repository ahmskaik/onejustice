var flag = true;
var groups;
var lists = function () {

    var handleUnsubscribeEmail = function () {
        jQuery(document).on('click', '.btn-unsubscribe', function () {
            var thisclick = jQuery(this);
            swal.fire({
                title: 'Are you sure?',
                text: "You are going to delete this maillist!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, understand that'
            }).then(function (result) {
                if (result.value && flag) {
                    flag = false;
                    jQuery.ajax({
                        type: 'GET',
                        url: thisclick.attr('href'),
                        dataType: 'json',
                        data: thisclick.serialize(),
                        beforeSend: function () {
                            KTApp.blockPage({
                                overlayColor: '#000000',
                                type: 'v2',
                                state: 'success',
                                message: 'Please wait...'
                            });
                        },
                        success: function (data) {
                            flag = true;
                            KTApp.unblockPage();
                            if (data.status) {
                                oTable.draw();
                                toastr.success(data.message, "Success Message");
                            } else {
                                toastr.error(data.message, data.title);
                            }
                        }, error: function (data) {
                            flag = true;
                            KTApp.unblockPage();
                        }
                    });
                }
            });
            return false;
        });
    };

    var handleAddMember = function () {
        jQuery(document).on('click', '.btn-addmemeber', function () {
            var thisclick = jQuery(this);


            jQuery.ajax({
                type: 'GET',
                url: thisclick.attr('href'),
                dataType: 'json',
                data: thisclick.serialize(),
                beforeSend: function () {
                    jQuery('#modal-updatemember').find('.js-modal-wrapper').html('<div class="m-4 text-center"><div style="margin: 0 auto; right: -44%;" class="kt-spinner kt-spinner--v2 kt-spinner--md kt-spinner--info"></div></div>')
                    jQuery('#modal-updatemember').find('.modal-title').text('Add Member');
                    KTApp.blockPage({
                        overlayColor: '#000000',
                        type: 'v2',
                        state: 'success',
                        message: 'Please wait...'
                    });
                },
                success: function (data) {
                    flag = true;
                    KTApp.unblockPage();
                    jQuery('#modal-updatemember').find('.js-modal-wrapper').html(data.body)
                },
                error: function (data) {
                    flag = true;
                    KTApp.unblockPage();
                }
            });

            return false;
        });

        jQuery(document).on("submit", ".updatemember-form", function () {
            if (flag) {
                flag = false;
                var thisclick = jQuery(this);
                jQuery.ajax({
                    type: 'POST',
                    url: thisclick.attr('action'),
                    dataType: 'json',
                    data: thisclick.serialize(),
                    beforeSend: function () {
                        KTApp.blockPage({
                            overlayColor: '#000000',
                            type: 'v2',
                            state: 'success',
                            message: 'Please wait...'
                        });
                    },
                    success: function (data) {
                        flag = true;
                        KTApp.unblockPage();
                        if (data.status) {
                            oTable.draw();
                            jQuery('#modal-updatemember').modal('hide');
                            $('.txtinput-email').val("");
                            toastr.success(data.message, "Success Message");
                        } else {
                            toastr.error(data.message, data.title);
                        }
                    },
                    error: function (data) {
                        flag = true;
                        KTApp.unblockPage();
                    }
                });
            }

            return false;
        });
    };

    var handleUpdateMember = function () {
        jQuery(document).on('click', '.btn-updatemember', function () {
            var thisclick = jQuery(this);

            flag = false;
            jQuery.ajax({
                type: 'GET',
                url: thisclick.attr('href'),
                dataType: 'json',
                data: thisclick.serialize(),
                beforeSend: function () {
                    jQuery('#modal-updatemember').find('.js-modal-wrapper').html('<div class="m-4 text-center"><div style="margin: 0 auto; right: -44%;" class="kt-spinner kt-spinner--v2 kt-spinner--md kt-spinner--info"></div></div>')
                    KTApp.blockPage({
                        overlayColor: '#000000',
                        type: 'v2',
                        state: 'success',
                        message: 'Please wait...'
                    });
                },
                success: function (data) {
                    flag = true;
                    KTApp.unblockPage();
                    jQuery('#modal-updatemember').find('.js-modal-wrapper').html(data.body)
                },
                error: function (data) {
                    flag = true;
                    KTApp.unblockPage();
                }
            });


            var email_text = jQuery(this).parents('tr').find('.btn-editmember').text().trim();
            jQuery('#modal-updatemember').find('.modal-title').text('Update Member');
            jQuery(".updatemember-form").attr("action", thisclick.attr("href"));
            jQuery('#modal-updatemember').modal('show');
            $('#modal-updatemember').on('shown.bs.modal', function () {
                $('.txtinput-email').focus();
            });
            return false;
        });

    };

    var type = false;
    var handleImportList = function () {
        jQuery(document).on('change', '.upload-list', function () {
            //var my_file = this.files[0];
            var file = jQuery(this).val();
            var extension = file.substr((file.lastIndexOf('.') + 1)).toLowerCase();
            type = extension == 'csv';
        });

        jQuery(document).on('submit', '.js-import-contacts-form', function () {
            var thisclick = jQuery(this);

            if (flag == true) {
                flag = false;
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                if (type == true) {
                    var form = document.getElementById('js-import-contacts-form');
                    var formData = new FormData(form);

                    /*fd.append("choose-file", my_file);
                    fd.append("groups[]", $('[name="groups[]"]').val());*/
                    jQuery.ajax({
                        type: 'POST',
                        url: thisclick.attr('action'),
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: "json",
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();
                            $(".progress-striped").show();
                            xhr.upload.addEventListener('progress', function (e) {
                                if (e.lengthComputable) {
                                    var prog = (e.loaded / e.total) * 100 + '%';
                                    jQuery('.progress-bar').css('width', prog);
                                }
                            }, false);

                            return xhr;
                        },
                        beforeSend: function () {
                            $(".progress-striped").show();
                        },
                        success: function (data) {
                            flag = true;
                            $(".progress-striped").hide();
                            jQuery('#modal-import').modal('hide');

                            oTable.draw();
                            if (data.status == true) {
                                toastr.success(data.message, "Upload Success");
                            } else {
                                toastr.error(message, data.title);
                            }
                        }, error: function (data) {
                            flag = true;
                        }
                    });

                } else {
                    flag = true;
                    jQuery(this).val("");
                    var message = '';
                    if (type == false)
                        message = 'format not accepted';
                    toastr.error(message, "Upload Error");
                }
            }
            return false;
        });
    }

    var handleOpenImport = function () {
        jQuery(document).on('click', '.btn-modalimport', function () {
            var thisclick = jQuery(this);
            jQuery('#modal-import').modal('show');
            return false;
        });
    };

    var handleTable = function () {
        oTable = $('#mydatatable').DataTable({
            "processing": true,
            "serverSide": true,
            pageLength: 40,
            "dom": "<'table-scrollable'rt><'row'<'col-md-5 col-sm-5'i><'col-md-7 col-sm-7'p>> ",
            "ajax": cp_route_name + "/mails/maillist/list",
            "order": [[5, 'desc']],
            "columns": [
                {data: 'id', name: 'id', orderable: true},
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {
                    'render': function (data, type, row) {
                        var tmp = '', counter = 0;
                        //return row['interests'];
                        for (var key in row['interests']) {
                            if (row['interests'][key]) {
                                if (counter)
                                    tmp += ' | ' + groups[key];
                                else
                                    tmp = groups[key];
                                ++counter;
                            }
                        }

                        return tmp;
                    }
                },
                {data: 'status', name: 'status'},
                {data: 'timestamp_opt', name: 'timestamp_opt'},
                {data: 'ip_signup', name: 'ip_signup'},
                {data: 'action', name: 'action', orderable: true},
            ],
            "fnDrawCallback": function (oSettings) {
                oTable.column(0).nodes().each(function (cell, i) {
                    cell.innerHTML = (parseInt(oTable.page.info().start)) + i + 1;
                });
            },
            "autoWidth": false,
            "scrollX": true,
        });
    };

    var handleGroups = function (gr) {
        groups = gr;
    };

    return {
        init: function (gr) {
            handleUnsubscribeEmail();
            handleAddMember();
            handleUpdateMember();
            handleImportList();
            handleOpenImport();
            handleTable();
            handleGroups(gr);
        }
    };

}
();
