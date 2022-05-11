jQuery(document).ready(function () {
    $('.myselect2').select2({
        placeholder: "Select Option",
        allowClear: true,
        width: 'resolve'
    });
    jQuery(document).on('click', '.cleardate', function () {
        jQuery(this).parents('.inputdate-wicon').find('.inputdateclear').val('');
        jQuery(this).parents('.inputdate-wicon').find('.cleardate').addClass('display-none');
        input_wlbl();
        oTable.columns(4).search(jQuery('#start-range-datepicker').val() + '|' + jQuery('#end-range-datepicker').val()).draw();
        return false;
    });

    jQuery(document).on('click', '.js-show-advance-filter', function () {
        $('.js-advance-filter-row').toggleClass('kt-hidden');
    });

    jQuery(document).on('change', '.inputdateclear', function () {
        if (jQuery(this).parents('.inputdate-wicon').find('.inputdateclear').val()) {
            jQuery(this).parents('.inputdate-wicon').find('.cleardate').removeClass('display-none');
        } else {
            jQuery(this).parents('.inputdate-wicon').find('.cleardate').addClass('display-none');
        }
    });


    var flag = true;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var oTable = $('#mydatatable').DataTable({
        "processing": true,
        "serverSide": true,
        pageLength: 20,
        "dom": "<'table-scrollable'rt><'row'<'col-md-5 col-sm-5'i><'col-md-7 col-sm-7'p>> ",
        "ajax": {
            url: cp_route_name + '/inquiries/list',
            method: 'GET',
            "data": function (d) {
            }
        },
        "order": [[6, 'desc']],
        "columns": [
            {data: 'id', name: 'inquiries.id', orderable: true},
            {data: 'title', name: 'title', searchable: false},
            {data: 'name', name: 'name', searchable: false},
            {data: 'email', name: 'email', searchable: false},
            {data: 'ip', name: 'ip', searchable: false},
            {data: 'status', name: 'seen_at', searchable: false},
            {data: 'created_at', name: 'inquiries.created_at', searchable: false},
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

    $('.searchable').change(function () {
        if (flag) {
            flag = false;
            var column = jQuery(this).attr('data-column');
            oTable.columns(column).search(jQuery(this).val()).draw();
        }
        flag = true;
    });
    $('.searchable-list').change(function () {
        if (flag) {
            flag = false;
            oTable.draw();
        }
        flag = true;
    });
    $('.search-status').change(function () {
        if (flag) {
            flag = false;
            var column = jQuery(this).attr('data-column');
            oTable.columns(column).search(jQuery(this).val()).draw();
        }
        flag = true;
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

    $('button[type="reset"]').click(function (e) {
        oTable.columns().search('').draw();
    });

    jQuery(document).on('click', '.cleardate', function () {
        jQuery(this).parents('.inputdate-wicon').find('.inputdateclear').val('');
        jQuery(this).parents('.inputdate-wicon').find('.cleardate').addClass('display-none');

        input_wlbl();

        var startRange = $('#start-range-datepicker').val();
        var endRange = $('#end-range-datepicker').val();

        oTable.columns(8).search(startRange + ' | ' + endRange).draw();

        return false;
    });

    jQuery(document).on("click", ".btn-delete", function () {
        if (!jQuery(this).attr("disabled")) {
            var this_click = jQuery(this);
            var name = this_click.data("name");
            swal.fire({
                title: "Are you sure you want to Delete " + name + "?",
                html: "<span class='blind-alert round'>Caution: You can not undo this operation !!..</span>><br><small class='kt-font-danger'>All of his participations and projects he own will be deleted as well.</small>",
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
                                }
                            }
                        });

                    }
                }
            );
        }

        return false;
    });
});
