jQuery().ready(function($) {
  // Show panels if "new object" is selected.
  if ( document.getElementById('first_object_id').value == 'new' ) {
    document.getElementById('first_object_panel').classList.remove("hide");
  }
  if ( document.getElementById('second_object_id').value == 'new' ) {
    document.getElementById('second_object_panel').classList.remove("hide");
  }
  
  // If "new object" is selected show the extra input panel
  $("select#first_object_id, select#second_object_id").on('change', function(){
    $panel = $(this).parents('div').next('.panel');
        
    if(this.value == 'new') {
      $panel.slideDown().removeClass('hide');
      
    } else if ( !$panel.hasClass('hide') ) {
      $panel.slideUp().addClass('hide');
      
    }
  });
});