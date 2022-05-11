var roles = function () {

    var handleBtnClear = function () {
        jQuery(document).on('click', '.cleardate', function () {
            jQuery(this).parents('.inputdate-wicon').find('.inputdateclear').val('');
            jQuery(this).parents('.inputdate-wicon').find('.cleardate').addClass('display-none');
            input_wlbl();
            oTable.columns(4).search(jQuery('#start-range-datepicker').val() + '|' + jQuery('#end-range-datepicker').val()).draw();
            return false;
        });
    };

    var handleInputDate = function () {
        jQuery(document).on('change', '.inputdateclear', function () {
            if (jQuery(this).parents('.inputdate-wicon').find('.inputdateclear').val()) {
                jQuery(this).parents('.inputdate-wicon').find('.cleardate').removeClass('display-none');
            }else {
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
    roles.init();
    var flag = true;
    jQuery(document).on('change', '.rb-changerole', function () {
        if (jQuery(this).hasClass('rb-chrole-more') && (jQuery(this).is(':checked'))) {
            jQuery('.select2-role-rg').removeClass('display-none');
        }
        else {
            jQuery('.select2-role-rg').addClass('display-none');
        }
    });

    $.fn.select2.defaults.set("theme", "bootstrap");
    var placeholder = "Select a State";

    $(".changerole-mselect2").select2({
        placeholder: placeholder,
        width: null
    });

    var roleid;
    var roletxt;
    var thisclick;
    jQuery(document).on('click', '.btn-ustatus', function () {
        thisclick = jQuery(this);
        roleid = thisclick.parents('tr').find('.roletxt').attr('data-id');
        if (thisclick.hasClass('ustatus-inactive')) {
            jQuery.ajax({
                url: cp_route_name + "/role/usersCount/" + roleid,
                type: 'GET',
                dataType: "json",
                success: function (data) {
                    if (data.status) {
                        if (data.usersCount > 0) {
                            var no_users = jQuery(this).parents('tr').find('.nousers').text().trim();
                            jQuery('#modal-changerole').on('show.bs.modal', function (e) {
                                jQuery(this).find('.bmodal-changerole .nouser').text(data.usersCount);
                            });
                            jQuery('#modal-changerole').modal('show');

                            roletxt = thisclick.parents('tr').find('.roletxt').text().trim();
                            jQuery('.rb-changerole').removeAttr('checked');
                            jQuery('.radio>span').removeClass('checked');
                            jQuery('.select2-role-rg').addClass('display-none');
                            jQuery('select.changerole-mselect2').find('option').removeAttr('disabled');
                            jQuery('select.changerole-mselect2').find('option[value=' + roleid + ']').attr('disabled', 'disabled');
                            jQuery('select.changerole-mselect2').select2({
                                placeholder: placeholder,
                                width: null
                            });
                        } else {
                            jQuery.ajax({
                                url: thisclick.attr('href'),
                                type: 'GET',
                                dataType: "json",
                                success: function (data) {
                                    if (data.status) {
                                        thisclick.removeClass('ustatus-inactive').addClass('ustatus-active');
                                        thisclick.find('i').addClass('fa-check-square').removeClass('fa-square-o');
                                        thisclick.parents('tr').find('.label').removeClass('label-success').addClass('label-danger').text('Inactive');
                                        thisclick.tooltipster('content', 'Active');

                                        toasterMessage("success", data.message, "Updated Successfully");
                                    }
                                }
                            });
                        }

                    } else {
                        toasterMessage("error", data.message, "Error");
                    }
                }
            });
        }
        else {
            jQuery.ajax({
                url: jQuery(this).attr('href'),
                type: 'GET',
                dataType: "json",
                success: function (data) {
                    if (data.status) {
                        thisclick.removeClass('ustatus-active').addClass('ustatus-inactive');
                        thisclick.find('i').removeClass('fa-check-square').addClass('fa-square-o');
                        thisclick.parents('tr').find('.label').removeClass('label-danger').addClass('label-success').text('Active');
                        thisclick.tooltipster('content', 'Deactivate');

                        toasterMessage("success", data.message, "Updated Successfully");
                    }
                }
            });

        }
        return false;
    });

    jQuery(document).on('click', '.btn-changerole', function () {
        var thisAction = jQuery(this);
        var deactivateUsers = thisAction.closest(".modal").find("#deactivateUsers").prop('checked');
        var isMove = thisAction.closest(".modal").find("#moveUsers").prop('checked');
        var newRole = thisAction.closest(".modal").find("#roles").val();
        if (deactivateUsers || (isMove && newRole)) {
            if (flag) {
                flag = false;
                jQuery.ajax({
                    url: thisclick.attr('href'),
                    type: 'GET',
                    data: { "isDeactivate": deactivateUsers, "isMove": isMove, "newRole": newRole },
                    dataType: "json",
                    success: function (data) {
                        flag = true;
                        if (data.status) {
                            thisclick.removeClass('ustatus-inactive').addClass('ustatus-active');
                            thisclick.find('i').addClass('fa-check-square').removeClass('fa-square-o');
                            thisclick.parents('tr').find('.label').removeClass('label-success').addClass('label-danger').text('Inactive');
                            thisclick.tooltipster('content', 'Active');
                            jQuery('#modal-changerole').modal('hide');
                            if (data.type == "move") {
                                thisclick.parents('tr').find('.nousers').text("0");
                            }
                            toasterMessage("success", data.message, "Updated Successfully");

                            roleid = "";
                            roletxt = "";
                            thisclick = "";
                        }
                    }
                });
            }
        }
    });

    jQuery(document).on('click', '.btn-role-search', function () {
        oTable.draw();
    });

    oTable = $('#mydatatable').DataTable({
        "processing": true,
        "serverSide": true,
        pageLength: 10,
        "dom": "<'table-scrollable'rt><'row'<'col-md-5 col-sm-5'i><'col-md-7 col-sm-7'p>> ",
        "ajax": cp_route_name + "/role/list",
        "order": [[4, 'desc']],
        "columns": [
            { data: 'id', name: 'id', orderable: false },
            { data: 'name', name: 'name', searchable: false },
            { data: 'status', name: 'roles.status' },
            { data: 'userCounter', name: 'userCounter' },
            { data: 'created_at', name: 'created_at', searchable: false },
            { data: 'full_name', name: 'full_name',searchable: false, orderable: false },
            { data: 'action', name: 'action',searchable: false, orderable: false  }
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

        oTable.columns(4).search(startRange + ' | ' + endRange).draw();
    });

    $('#end-range-datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
        endDate: '0d'
    }).on('changeDate', function (e) {
        var startRange = $('#start-range-datepicker').val();
        var endRange = $(this).val();

        oTable.columns(4).search(startRange + ' | ' + endRange).draw();
    });

    jQuery(document).on('click', '.btn-reset', function () {
        $('.form-control').val('');
        oTable.columns().search('').draw();
    });
    jQuery(document).on("click", ".btn-delete", function () {
        if (!jQuery(this).attr("disabled")) {
            thisclick = jQuery(this);
            var name = $(this).data("name");
            roleid = thisclick.parents('tr').find('.roletxt').attr('data-id');
            swal.fire({
                title:"Are you sure you want to Delete (" + name + ") role?",
                html: "<a class='blind-alert round'>Caution: You can not undo this operation !!..<a/>",
                type: 'info',
                showCancelButton: true,
                confirmButtonText: "Ok, I understand",
                cancelButtonText: "Cancel",
            }).then(function (result) {
                if (result.value) {
                    jQuery.ajax({
                        url: cp_route_name + "/role/usersCount/" + roleid,
                        type: 'GET',
                        dataType: "json",
                        success: function (data) {
                            if (data.status) {
                                if (data.usersCount > 0) {
                                    var no_users = jQuery(this).parents('tr').find('.nousers').text().trim();
                                    jQuery('#modal-deleterole').on('show.bs.modal', function (e) {
                                        jQuery(this).find('.bmodal-changerole .nouser').text(data.usersCount);
                                    });
                                    jQuery('#modal-deleterole').modal('show');

                                    roletxt = thisclick.parents('tr').find('.roletxt').text().trim();
                                    jQuery('.rb-changerole').removeAttr('checked');
                                    jQuery('.radio>span').removeClass('checked');
                                    jQuery('.select2-role-rg').addClass('display-none');
                                    jQuery('select.changerole-mselect2').find('option').removeAttr('disabled');
                                    jQuery('select.changerole-mselect2').find('option[value=' + roleid + ']').attr('disabled', 'disabled');
                                    jQuery('select.changerole-mselect2').select2({
                                        placeholder: placeholder,
                                        width: null
                                    });
                                } else {
                                    jQuery.ajax({
                                        url: thisclick.attr('href'),
                                        type: 'GET',
                                        dataType: "json",
                                        success: function (data) {
                                            if (data.status) {
                                                oTable.draw();
                                                toasterMessage("success", data.message, "Updated Successfully");
                                            }
                                        }
                                    });

                                }

                            } else {
                                toasterMessage("error", data.message, "Error");
                            }
                        }
                    });
                }
            });
        }
        return false;
    });

    jQuery(document).on('click', '.btn-deleterole', function () {
        var thisAction = jQuery(this);
        var deactivateUsers = thisAction.closest(".modal").find("#deactivateUsers").prop('checked');
        var isMove = thisAction.closest(".modal").find("#moveUsers").prop('checked');
        var newRole = thisAction.closest(".modal").find("#roles").val();
        var deleteUsers = thisAction.closest(".modal").find("#deleteUsers").prop('checked');
        if (deactivateUsers || (isMove && newRole) || deleteUsers) {
            if (flag) {
                flag = false;
                jQuery.ajax({
                    url: thisclick.attr('href'),
                    type: 'GET',
                    data: { "isDeactivate": deactivateUsers, "isMove": isMove, "newRole": newRole, 'deleteUsers': deleteUsers },
                    dataType: "json",
                    success: function (data) {
                        flag = true;
                        if (data.status) {
                            thisclick.removeClass('ustatus-inactive').addClass('ustatus-active');
                            thisclick.find('i').addClass('fa-check-square').removeClass('fa-square-o');
                            thisclick.parents('tr').find('.label').removeClass('label-success').addClass('label-danger').text('Inactive');
                            thisclick.tooltipster('content', 'Active');
                            jQuery('#modal-deleterole').modal('hide');
                            if (data.type == "move") {
                                thisclick.parents('tr').find('.nousers').text("0");
                            } else if (data.type == "deleted") {
                                oTable.draw();
                            }
                            toasterMessage("success", data.message, "Updated Successfully");

                            roleid = "";
                            roletxt = "";
                            thisclick = "";
                        }
                    }
                });
            }
        }
    });

});
