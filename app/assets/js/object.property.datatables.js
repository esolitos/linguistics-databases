jQuery().ready(function($) {
    var $table = $('table.defined-object-properties');
    
    var table = $table.DataTable({
        deferRender: true,
        order: [[1, 'asc']],
        columnDefs: [
            { "targets": [ -2, -1], "searchable": false, "orderable": false },
        ]
        
    });
});
