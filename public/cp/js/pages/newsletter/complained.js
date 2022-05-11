var flag = true;
jQuery(document).ready(function () {
    oTable = $('#mydatatable').DataTable({
        "iDisplayLength": 50,
        "processing": true,
        "serverSide": true,
        pageLength: 40,
        "dom": "<'table-scrollable'rt><'row'<'col-md-5 col-sm-5'i><'col-md-7 col-sm-7'p>> ",
        "ajax": jQuery("#mydatatable").attr("data-link"),
        "columns": [
            {data: 'email_address', name: 'email_address', orderable: false},
            {data: 'email_address', name: 'email_address', orderable: false},
            {data: 'date', name: 'date', orderable: false},
        ],
        "fnDrawCallback": function (oSettings) {
            oTable.column(0).nodes().each(function (cell, i) {
                cell.innerHTML = (parseInt(oTable.page.info().start)) + i + 1;
            });
        },
        "autoWidth": false,
        "scrollX": true,
    });
});
