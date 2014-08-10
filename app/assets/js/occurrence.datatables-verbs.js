jQuery().ready( function ($) {
    var $table = $('table#verbs-listing');
    
    var table = $table.DataTable({
        order: [[1, 'desc']],
        columnDefs: [
            { "targets": [-2, -1], "searchable": false, "orderable": false },
            { "targets": [0], "searchable": true, "orderable": true },
            { "targets": [1], "searchable": false, "orderable": true },
        ],
        
    });

} );