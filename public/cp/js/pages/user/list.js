var users = function () {

    var handleBtnClear = function () {
        jQuery(document).on('click', '.cleardate', function () {
            jQuery(this).parents('.inputdate-wicon').find('.inputdateclear').val('');
            jQuery(this).parents('.inputdate-wicon').find('.cleardate').addClass('display-none');
            input_wlbl();
            oTable.columns(7).search(jQuery('#start-range-datepicker').val() + '|' + jQuery('#end-range-datepicker').val()).draw();
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

    return {
        init: function () {
            handleBtnClear();
            handleInputDate();
        }
    };

}();

jQuery(document).ready(function () {
    users.init();
    var flag = true;
    oTable = $('#mydatatable').DataTable({
        "processing": true,
        "serverSide": true,
        pageLength: 10,
        "dom": "<'table-scrollable'rt><'row'<'col-md-5 col-sm-5'i><'col-md-7 col-sm-7'p>> ",
        "ajax": cp_route_name + "/user/list",
        "order": [[7, "desc"]],
        "columns": [
            {data: 'id', name: 'id', orderable: false,},
            {data: 'full_name', name: 'full_name', searchable: false,},
            {data: 'role_name', name: 'role_id', searchable: false,},
            {data: 'user_name', name: 'user_name'},
            {data: 'status', name: 'system_users.status'},
            {data: 'email', name: 'system_users.email'},
            {data: 'created_by', name: 'su.full_name', searchable: false,},
            {data: 'created_at', name: 'created_at', searchable: false,},
            {data: 'action', name: 'action', orderable: false,}
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

    jQuery(document).on('click', '.sorting_1', function () {
        mytooltipster();
        $('.popovers').popover();
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


    $('#start-range-datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        endDate: '0d'
    }).on('changeDate', function (e) {
        var startRange = $(this).val();
        var endRange = $('#end-range-datepicker').val();

        oTable.columns(7).search(startRange + ' | ' + endRange).draw();
    });

    $('#end-range-datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        endDate: '0d'
    }).on('changeDate', function (e) {
        var startRange = $('#start-range-datepicker').val();
        var endRange = $(this).val();

        oTable.columns(7).search(startRange + ' | ' + endRange).draw();
    });

    jQuery(document).on('click', '.btn-reset', function () {
        $('.form-control').val('');
        oTable.columns().search('').draw();
    });

    $.fn.select2.defaults.set("theme", "bootstrap");
    var placeholder = "Select a State";

    $(".change-role-select2").select2({
        placeholder: placeholder,
        width: null
    });

    jQuery(document).on('click', '.btn-dropdown-wstatus', function () {
        if (jQuery(this).attr('disabled') != "disabled") {
            if (jQuery(this).parents('.btn-dropdown-wstatusrg').hasClass('open')) {
                jQuery(this).parents('.btn-dropdown-wstatusrg').removeClass('open');
            } else {
                jQuery(this).parents('.btn-dropdown-wstatusrg').addClass('open');
            }
        }
    });

    jQuery(document).on('click', '.btn-dropdown-wselect', function () {
        if (jQuery(this).attr('disabled') != "disabled") {
            if (jQuery(this).parents('.btn-dropdownrg').hasClass('open')) {
                jQuery(this).parents('.btn-dropdownrg').removeClass('open');
            } else {
                jQuery(this).parents('.btn-dropdownrg').addClass('open');
            }
        }
    });

    jQuery(document).on('click', 'body', function (e) {
        var target = $(e.target);
        if (!$(e.target).is('.dropdown-wselect, .dropdown-wselect *, .btn-dropdown-wselect, .btn-dropdown-wselect *,.select2-search__field')) {
            $('.btn-dropdownrg').removeClass('open');
        }
    });

    jQuery(document).on('click', 'body', function (e) {
        var target = $(e.target);
        if (!$(e.target).is('.btn-dropdown-wstatusrg ,.btn-dropdown-wstatus, .btn-dropdown-wstatus *')) {
            $('.btn-dropdown-wstatusrg').removeClass('open');
        }
    });

    jQuery(document).on('change', '.change-role-select2', function () {
        var thisclick = jQuery(this);
        var id = [];
        var roleid = thisclick.val();
        var name = thisclick.find("option:selected").text();
        thisclick.parents('.select2-wlbl').find('.select2-container--default').removeClass('select2-container-openmy');

        swal.fire({
            title:"Are you sure you want to change role for " + jQuery(".checkboxes:checked").not(".checkbox-parent").size() + " user to " + name + " role?",
            html: "<span class='blind-alert round'>Caution: You can not undo this operation !!..</span>>",
            type: 'info',
            showCancelButton: true,
            confirmButtonText: "Ok, I understand",
            cancelButtonText: "Cancel",
        }).then(function (result) {
            if (result.value) {
                jQuery("#mydatatable").find(".checkboxes:checked").each(function () {
                    id.push(jQuery(this).parents('tr').find('.userid').attr('data-id'));
                });
                if (flag) {
                    flag = false;
                    jQuery.ajax({
                        url: cp_route_name + "/user/changeRole",
                        type: 'GET',
                        data: {"id": id, roleid: roleid},
                        dataType: "json",
                        success: function (data) {
                            if (data.status) {
                                flag = true;
                                thisclick.parents('.btn-dropdownrg').removeClass('open');
                                jQuery("#mydatatable").find(".checkboxes:checked").each(function () {
                                    jQuery(this).parents('tr').find(".roleName").text(name);
                                });
                                toasterMessage("success", data.message, "Updated Successfully");
                            }
                        },
                        error: function (data) {
                            toasterMessage("error", "Please Check Selected Role", "CHeck Error");
                        }
                    });
                }
            }
        });

    });

    // for change status
    jQuery(document).on('click', '.btn-ustatus', function () {
        thisclick = jQuery(this);
        var status = "";
        if (thisclick.hasClass('ustatus-inactive'))
            status = "SYSTEM_USER_STATUS_DEACTIVE";
        else
            status = "SYSTEM_USER_STATUS_ACTIVE";
        jQuery.ajax({
            url: jQuery(this).attr('href'),
            type: 'GET',
            data: {"id[]": thisclick.parents('tr').find('.userid').attr('data-id'), status: status},
            dataType: "json",
            success: function (data) {
                if (data.status) {
                    if (thisclick.hasClass('ustatus-inactive')) {
                        thisclick.removeClass('ustatus-inactive').addClass('ustatus-active');
                        thisclick.find('i').removeClass('fa-square-o').addClass('fa-check-square');
                        thisclick.parents('tr').find('.label').removeClass('label-success').addClass('label-danger').text('Inactive');
                        thisclick.tooltipster('content', 'Activate');
                    } else {
                        thisclick.removeClass('ustatus-active').addClass('ustatus-inactive');
                        thisclick.find('i').removeClass('fa-check-square').addClass('fa-square-o');
                        thisclick.parents('tr').find('.label').removeClass('label-danger').addClass('label-success').text('Active');
                        thisclick.tooltipster('content', 'Deactivate');
                    }

                    toasterMessage("success", data.message, "Updated Successfully");
                }
            }
        });

        return false;
    });

    jQuery(document).on('click', '.umodal', function () {
        var userid = jQuery(this).parents('tr').find('.userid').attr('data-id');
        jQuery(".id").val(userid);

        var target = jQuery(this).attr('data-modal');
        var txtuser = jQuery(this).parents('tr').find('.userid').text();
        jQuery('#' + target).find('.txtadminname').text(txtuser);
        jQuery('#modal-changepassword').find('.form-control').val('');
        jQuery('#switchsend').prop('checked', true);
        jQuery('#switchsend').bootstrapSwitch('destroy');
        jQuery('#switchsend').bootstrapSwitch();
        input_wlbl();
        jQuery('#' + target).modal('show');
        return false;
    });

    jQuery(document).on('submit', '#form-changePassword', function () {
        var thisAction = jQuery(this);

        if (!errors) {
            jQuery.ajax({
                url: cp_route_name + "/user/changePassword",
                type: 'POST',
                data: thisAction.serialize(),
                dataType: "json",
                success: function (data) {
                    if (data.status) {
                        jQuery('#modal-changepassword').modal('hide');
                        jQuery('#modal-changepassword').find('.form-control').val('');
                        input_wlbl();
                        toasterMessage("success", data.message, "Updated Successfully");
                    }
                },
                error: function (data) {
                    toasterMessage("error", "Check password and confirm", "CHeck Error");
                }
            });
        }

        return false;
    });

    // change all status
    jQuery('.confirm-msg').click(function () {
            var thisclick = jQuery(this);
            var status = "";
            var statusName = "";

            if (thisclick.hasClass("activate")) {
                status = "SYSTEM_USER_STATUS_ACTIVE";
                statusName = "activate";
            } else {
                status = "SYSTEM_USER_STATUS_DEACTIVE";
                statusName = "deactivate";
            }
            var id = [];
            if (jQuery('.checkboxes:checked').size() > 0) {
                bootbox.confirm("Are you sure you want to " + statusName + " " + jQuery(".checkboxes:checked").not(".checkbox-parent").size() + " users?", function (result) {
                        if (result) {

                            jQuery("#mydatatable").find(".checkboxes:checked").each(function () {
                                id.push(jQuery(this).parents('tr').find('.userid').attr('data-id'));
                            });
                            jQuery.ajax({
                                url: cp_route_name + "/user/changeStatus",
                                type: 'GET',
                                data: {"id": id, status: status},
                                dataType: "json",
                                success: function (data) {
                                    if (data.status) {
                                        if (status == "SYSTEM_USER_STATUS_ACTIVE") {
                                            jQuery("#mydatatable").find(".checkboxes:checked").each(function () {
                                                jQuery(this).parents('tr').find('.btn-ustatus').removeClass('ustatus-active').addClass('ustatus-inactive');
                                                jQuery(this).parents('tr').find('.btn-ustatus').find('i').removeClass('fa-check-square').addClass('fa-square-o');
                                                jQuery(this).parents('tr').find('.label').removeClass('label-danger').addClass('label-success').text('Active');
                                                jQuery(this).parents('tr').find('.btn-ustatus').tooltipster('content', 'Deactivate');
                                            });

                                        } else {
                                            jQuery("#mydatatable").find(".checkboxes:checked").each(function () {
                                                jQuery(this).parents('tr').find('.btn-ustatus').removeClass('ustatus-inactive').addClass('ustatus-active');
                                                jQuery(this).parents('tr').find('.btn-ustatus').find('i').removeClass('fa-square-o').addClass('fa-check-square');
                                                jQuery(this).parents('tr').find('.label').removeClass('label-success').addClass('label-danger').text('Inactive');
                                                jQuery(this).parents('tr').find('.btn-ustatus').tooltipster('content', 'Activate');
                                            });
                                        }

                                        toasterMessage("success", data.message, "Updated Successfully");
                                    }
                                }
                            });
                        }
                    }
                );
            }
        }
    );


    jQuery(document).on("click", ".btn-delete", function () {
        if (!jQuery(this).attr("disabled")) {
            var this_click = jQuery(this);
            var name = $(this).data("name");

            swal.fire({
                title:"Are you sure you want to Delete "+name+"?",
                html: "<span class='blind-alert round'>Caution: You can not undo this operation !!..</span>>",
                type: 'info',
                showCancelButton: true,
                confirmButtonText: "Ok, I understand",
                cancelButtonText: "Cancel",
            }).then(function (result) {
                if (result.value) {
                    jQuery.ajax({
                        type: 'GET',
                        url: this_click.attr('href'),
                        dataType: 'json',
                        success: function (data) {
                            if (data.status) {
                                oTable.draw();
                                toastr.options.positionClass = "toast-bottom-right";
                                toastr.success(data.message);
                            } else {
                                toastr.options.positionClass = "toast-bottom-right";
                                toastr.error(data.message);
                               /* bootbox.confirm(data.message, function (result) {
                                    if (result) {
                                        window.top.location = (data.url);
                                    }
                                });*/
                            }
                        }
                    });
                }
            });

        }

        return false;
    });
});
