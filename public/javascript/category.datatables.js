jQuery().ready(function($) {
    var $table = $('table.defined-categories');
    
    var table = $table.DataTable({
        deferRender: true,
        columnDefs: [
            { "targets": [-3, -2, -1], "searchable": false, "orderable": false },
        ]
        
    });
});
