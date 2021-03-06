jQuery().ready( function ($) {
    var $table = $('table.occurrences-listing');
    
    var table = $table.DataTable({
        deferRender: true,
        order: [[1, 'asc']],
        columnDefs: [
            { "targets": [-2, -1], "searchable": false, "orderable": false },
            { "targets": 'ID', "searchable": false, "orderable": false },
            { "targets": [4, 5], "searchable": true, "visible": false, "orderable": false }
        ],
        initComplete: function () {
            this.css('width', "100%");
            $("#occurrences-listing-page").fadeIn('slow');
        }
        
    });

    var categories_filter = $("#filter-area .categories");
    table.column( 1 ).data().unique().sort().each( function ( d, j ) {

        categories_filter.append( '<li><label><input id="filter-cat-list-'+j+'" type="checkbox" name="categories" value="'+d+'"> '+d+'</label></li>');
    } );


    $("#filter-area .speakers input[name=speaker]").on('change', function(){
        $('.speakers .selected').removeClass('selected');
        this.parentNode.classList.add('selected');
        table.column( 4 ).search( this.value ).draw();
    } );


    $("#filter-area .categories input[type=checkbox]").on( 'change', function(){
        var $checkboxes = $("#filter-area .categories input[type=checkbox]:checked");

        if ( $checkboxes.size() ) {
            var search_str = "";
            $checkboxes.each( function(i){
                if( this.classList.contains('no-escape') ) {
                    search_str = search_str.concat('('+ this.value +')+|')
                } else {
                    search_str = search_str.concat('('+ RegExp.quote(this.value) +')+|')
                }
            } );

            table.column( 1 ).search( search_str.substring(0, search_str.length -1), true, false ).draw();
        } else {
            table.column( 1 ).search( '', true, false ).draw();
        }
        
        this.parentNode.classList.toggle('selected');
    } );

} );