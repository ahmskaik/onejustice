var flag = true;

var groups = function () {

    var handleBtnDeleteGroup = function () {
        jQuery(document).on('click', '.btn-delete', function () {
            var thisclick = jQuery(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            swal.fire({
                title: 'Are you sure?',
                text: "You are going to delete this group!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, understand that'
            }).then(function (result) {
                if (result.value && flag) {
                    flag = false;
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
                                toastr.success(data.message, data.title);
                            }
                        },
                        error: function (data) {
                            flag = true;
                            KTApp.unblockPage();

                        }
                    });
                }
            });
            return false;
        });
    };

    var handleTable = function () {
        oTable = $('#mydatatable').DataTable({
            "processing": true,
            "serverSide": true,
            pageLength: 40,
            "dom": "<'table-scrollable'rt><'row'<'col-md-5 col-sm-5'i><'col-md-7 col-sm-7'p>> ",
            "ajax": cp_route_name + "/mails/groups/list",
            "columns": [
                {data: 'id', name: 'id'},
                {data: 'name', name: 'name'},
                {data: 'id', name: 'id'},
                {data: 'subscriber_count', name: 'subscriber_count'},
                {data: 'action', name: 'action'}
            ],
            "fnDrawCallback": function (oSettings) {
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
    };

    return {
        init: function () {
            handleTable();
            handleBtnDeleteGroup();
        }
    };

}();

jQuery(document).ready(function () {
    groups.init();
});
