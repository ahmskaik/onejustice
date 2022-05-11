jQuery(document).ready(function () {
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
            url: cp_route_name + '/categories/list',
            method: 'GET',
        },
        "order": [[5, 'desc']],
        "columns": [
            {data: 'id', name: 'id', orderable: false},
            {data: 'category_name', name: 'category_name', searchable: false},
            {data: 'parent', name: 'parent_id', searchable: false},
            {data: 'statusValue', name: 'statusValue', searchable: false},
            {data: 'creator', name: 'created_by', searchable: false,},
            {data: 'dtime', name: 'dtime', searchable: false},
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

    $('button[type="reset"]').click(function (e) {
        oTable.columns().search('').draw();
    });

});
