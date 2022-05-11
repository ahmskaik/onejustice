var flag = true;
var campaign = function () {

    var handleBtnClear = function () {
        jQuery(document).on('click', '.cleardate', function () {
            jQuery(this).parents('.inputdate-wicon').find('.inputdateclear').val('');
            jQuery(this).parents('.inputdate-wicon').find('.cleardate').addClass('display-none');
            input_wlbl();
            oTable.columns(5).search("").draw();
            return false;
        });
    };

    var handleInputDate = function () {
        jQuery(document).on('change', '.inputdateclear', function () {
            if (jQuery(this).parents('.inputdate-wicon').find('.inputdateclear').val()) {
                jQuery(this).parents('.inputdate-wicon').find('.cleardate').removeClass('display-none');
            } else {
                jQuery(this).parents('.inputdate-wicon').find('.cleardate').addClass('display-none');
            }
        });
    };

    var handleActionCampaign = function () {
        jQuery(document).on('click', '.btn-actioncampaign', function () {
            if (window.innerWidth >= 720) {
                jQuery('.dataTables_scrollBody').addClass('bodytable-overflow');
            }
            if (!jQuery(this).parents('.btn-group').hasClass('open')) {
                jQuery('.btn-group').removeClass('open');
                jQuery(this).parents('.btn-group').addClass('open');
            } else {
                jQuery(this).parents('.btn-group').removeClass('open');
            }
            return false;
        });

        jQuery(document).on("vclick", "body", function (e) {
            var target = $(e.target);
            if (!$(e.target).is('.btn-actioncampaign, .btn-actioncampaign *')) {
                jQuery('.btn-group').removeClass('open');
            }
        });
    };

    var handleBtnDeleteCampaign = function () {
        jQuery(document).on('click', '.btn-deletecampaign', function () {
            var thisclick = jQuery(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            swal.fire({
                title: 'Are you sure?',
                text: "You are going to delete this campaign!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, understand that'
            }).then(function (result) {
                if (result.value && flag) {
                    jQuery.ajax({
                        type: 'DELETE',
                        url: thisclick.attr('href'),
                        dataType: 'json',
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
                        },
                        error: function (data) {
                            KTApp.unblockPage();
                        }
                    });
                }
            });
            return false;
        });
    };

    var handleBtnReplicateCampaign = function () {
        jQuery(document).on('click', '.btn-replicate', function () {
            var thisclick = jQuery(this);
            swal.fire({
                title: 'Are you sure?',
                text: "You are going to replicate this campaign!",
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
                                flag = true;
                                toastr.error(data.message, data.title);
                            }
                        }
                    });
                }
            });
            return false;
        });
    };

    var handleBtnSendTest = function () {
        jQuery(document).on('click', '.btn-sendtest', function () {
            var thisclick = jQuery(this);
            jQuery(".form-sendtest").attr("action", thisclick.attr("href"));
            jQuery('#modal-sendtest').modal('show');
            $('#modal-sendtest').on('shown.bs.modal', function () {
                $('.input-sendtest').focus();
            });
            return false;
        });

        jQuery(document).on("submit", ".form-sendtest", function () {
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
                            jQuery('#modal-sendtest').modal('hide');
                            $('input[name^=emails]').val("");
                            $('.bootstrap-tagsinput').find("input").val("");
                            $('.bootstrap-tagsinput').find(".tag").remove();
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

    var handleBtnViewDetails = function () {
        jQuery(document).on('click', '.btn-viewdetails', function () {
            if (flag) {
                flag = false;
                var thisclick = jQuery(this);
                jQuery.ajax({
                    type: 'GET',
                    url: thisclick.attr('href'),
                    dataType: 'json',
                    beforeSend: function () {
                        $('.iframe_preview').contents().find("body").html("");
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
                            $('.iframe_preview').contents().find("body").html(data.data);
                            jQuery('#modal-viewdetails').modal('show');
                        } else {
                            toastr.success(data.message, data.title);
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

    var handleBtnSendCampaign = function () {
        jQuery(document).on('click', '.btn-send', function () {
            var thisclick = jQuery(this);
            swal.fire({
                title: 'Are you sure?',
                text: "You are going to send campaign!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, understand that'
            }).then(function (result) {
                if (result.value && flag) {
                    jQuery.ajax({
                        type: 'GET',
                        url: thisclick.attr('href'),
                        dataType: 'json',
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
                                toastr.success(data.message, data.title);
                            }
                        },
                        error:function (data){
                            flag = true;
                            KTApp.unblockPage();
                        }
                    });
                }});
            return false;
        });
    };

    var handleValidateSendTest = function () {
        jQuery(document).on('submit', '.form-sendtest', function () {
            var not_emails = 0;
            if (jQuery(this).find('.input-sendtest').val()) {
                jQuery(this).parent().find('.bootstrap-tagsinput').removeClass('has-error');
            } else {
                jQuery(this).parent().find('.bootstrap-tagsinput').addClass('has-error');
                Command: toastr["error"]("Please enter at least one email", "Error");
                return false;
            }
            var emailreg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            jQuery(this).find('.bootstrap-tagsinput>.tag').each(function () {
                if (jQuery(this).length > 0 && emailreg.test(jQuery(this).text().trim()) == false) {
                    not_emails++;
                }
            });
            if (not_emails > 0) {
                jQuery(this).parent().find('.bootstrap-tagsinput').addClass('has-error');
                Command: toastr["error"]("There " + not_emails + " not emails", "Error");
                return false;
            } else {
                jQuery(this).parent().find('.bootstrap-tagsinput').removeClass('has-error');
            }
        });
    };

    var handleHideSendtest = function () {
        $('#modal-sendtest').on('hidden.bs.modal', function () {
            $(".input-sendtest").tagsinput('removeAll');
        });
    };

    return {
        init: function () {
            handleBtnClear();
            handleInputDate();
            handleActionCampaign();
            handleBtnDeleteCampaign();
            handleBtnSendTest();
            handleBtnViewDetails();
            handleValidateSendTest();
            handleBtnReplicateCampaign();
            handleBtnSendCampaign();
            handleHideSendtest();
        }
    };

}();

jQuery(document).ready(function () {
    campaign.init();

    oTable = $('#mydatatable').DataTable({
        "processing": true,
        "serverSide": true,
        pageLength: 40,
        "dom": "<'table-scrollable'rt><'row'<'col-md-5 col-sm-5'i><'col-md-7 col-sm-7'p>> ",
        "ajax": cp_route_name + "/mails/list",
        "columns": [
            {data: 'id', name: 'id'},
            {data: 'settings.title', name: 'title'},
            {data: 'settings.subject_line', name: 'subject'},
            {data: 'status', name: 'status'},
            {data: 'opens', name: 'opens'},
            {data: 'create_time', name: 'create_time'},
            {data: 'send_time', name: 'since_send_time'},
            {data: 'action', name: 'action'},
        ],
        "fnDrawCallback": function (oSettings) {
            KTApp.initTooltips();
            oTable.column(0).nodes().each(function (cell, i) {
                cell.innerHTML = (parseInt(oTable.page.info().start)) + i + 1;
            });
            var input = oSettings.oAjaxData;
            input.length = "";
            input.start = "";
            input = jQuery.param(input);
            input = input.replace("&length=", "");
            input = input.replace("&start=", "");
            $(".exportData").each(function () {
                $(this).attr("href", $(this).data("href") + input);
            });
        },
        //responsive: true,
        "autoWidth": false,
        "scrollX": true,
    });

    jQuery(document).on('click', '.btn-submit-search', function () {
        oTable.draw();
    });

    $('.searchable').change(function () {
        if (flag) {
            flag = false;
            var column = jQuery(this).attr('data-column');
            oTable.columns(column).search(jQuery(this).val()).draw();
        }
        flag = true;
    });

    $('.searchableList').change(function () {
        var column = $(this).attr('data-column');
        oTable.columns(column).search($(this).val()).draw();
    });

    jQuery(document).on('click', '.btn-reset', function () {
        $('.form-control').val('');
        oTable.columns().search('').draw();
    });

    $('#send_date').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    }).on('change', function (e) {
        var date = $(this).val();
        oTable.columns(5).search(date).draw();
    });
});
