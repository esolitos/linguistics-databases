// Foundation JavaScript
// Documentation can be found at: http://foundation.zurb.com/docs
$().ready(function() {
    $(document).foundation();
});

$().ready(function() {
    $("select#first_object_id, select#second_object_id").on('change', function(){
        $panel = $(this).parents('.row').next('.panel');
        
        if(this.value == 'new') {
            $panel.slideDown().removeClass('hide');
        } else if ( !$panel.hasClass('hide') ) {
           
            $panel.slideUp().addClass('hide');
        }
    });
});
