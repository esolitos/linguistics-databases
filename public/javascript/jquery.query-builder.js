jQuery(document).ready(function($) {
    var query = { output: { object: '', type: '' }, constraints: [] };
    
    $('#add-output').click(function(event) {
        event.preventDefault();
        var outputObj = $("select[name=output-object]").val(),
          outputType = $("select[name=output-type]").val();
        
        
        if ( outputObj != undefined & outputType != undefined && outputObj != -1 ) {
            $('#select-output p.placeholder').slideDown();
            $('#select-output div.options').slideUp();
            
            query.output = {
                'object': outputObj,
                'type': outputType
            };
            
            showConstriants();
        } else {
            alert('Select a correct Output object and Output Style.');
        }
        
        buildQueryMessage(query);
        console.log(query);
    });
    
    
    $("#mod-output").click(function(event) {
        event.preventDefault();
        
        query.output = {
            object: '',
            type: ''
        }
        
        showOutput();
        buildQueryMessage(query);
    });
    
    
    $("#add-category").click(function(event) {
        event.preventDefault();
        var catId = $("select[name=category-id]").val(),
          catOp = $("select[name=category-op]").val();
        
        if (catOp != undefined && catId != undefined) {
            addConstraint('category', 'category', catOp, catId);
        }
    });
    
    
    $("#add-occurrence-prop").click(function(event) {
        event.preventDefault();
        var propType = $("#occurrence-prop-type").val(),
          propOp = $("#occurrence-prop-op").val(),
          propVal = $("#occurrence-prop-value").val();
        
        if (propType != undefined && propOp != undefined && propVal != undefined) {
            addConstraint('occurrence', propType, propOp, propVal);
        }
    });
    
    
    $("#add-object-prop").click(function(event) {
        event.preventDefault();
        var propType = $("#object-prop-type").val(),
          propOp = $("#object-prop-op").val(),
          propVal = $("#object-prop-id").val();
        
        if (propType != undefined && propOp != undefined && propVal != undefined) {
            addConstraint('object-property', propType, propOp, propVal);
        }
    });
    
    $("#verify-built-query").click(function(event) {
        event.preventDefault();
        console.log(JSON.stringify(query));
        $.ajax('/double-object/query/verify', {
          type: 'POST',
          dataType: 'json',
          data: {
              _token: $("input[name=_token]").val(),
              query_structure: query
          },
          success: function(data, textStatus, xhr) {
              console.log(data);
              
              if ( typeof data.error !== 'undefined' ) {
                  showAlertBox({
                      title: "Error on: " + data.error.type,
                      message: data.error.message
                  });
              }
          },
          error: function(xhr, textStatus, errorThrown) {
              // console.error(textStatus);
              // console.error(errorThrown);
              showAlertBox({
                  title: "Verification Error",
                  message: errorThrown
              });
          }
      });
        
    });
    
    $('select[name=category-op]').change(function(event) {
        if ( this.value.indexOf('IN') >= 0 ) {
            $('select[name=category-id]').attr('multiple', true);
            
        } else {
            $('select[name=category-id]').attr('multiple', false);
        }
    });
    
    function showOutput() {
        $('#select-output p.placeholder').slideUp();
        $('#select-output div.options').slideDown();
        
        $('#add-constraints p.placeholder').slideDown();
        $('#add-constraints div.options').slideUp();
    }
    
    function showConstriants() {
        $('#select-output p.placeholder').slideDown();
        $('#select-output div.options').slideUp();
        
        $('#add-constraints p.placeholder').slideUp();
        $('#add-constraints div.options').slideDown();
    }
    
    
    function addConstraint(type, propName, op, val) {
        
        query.constraints.push({
            'type': type,
            'name': propName,
            'operator': op,
            'value': val
        });
        
        buildQueryMessage(query);
    }
    
    
    /*
     * Based on the db query object builds a descriptive text of the query itself.
     */
    function buildQueryMessage(queryObj) {
        var $messageArea = $("#query-area .text"),
        text = "";
        
        if ( queryObj.output.object.length != 0 && queryObj.output.type.length != 0 ) {
            var outObj = $("select[name=output-object] option[value="+queryObj.output.object+"]").text();

            text = "You will receive in output ";
            switch ( queryObj.output.type ) {
            case 'ALL':
                text = text.concat('a table of ');
                break;
            case 'NAME':
                text = text.concat('a list of names of ');
                break;
            case 'COUNT':
                text = text.concat('a number indicating the amount of ');
                break;
            }
              
            text = text.concat(outObj+" based on the following constraints.<br>");
              
            if ( queryObj.constraints.length > 0 ) {
                text = text.concat('<h5 class="subheader">Constraints:</h5>');

                for (var i = queryObj.constraints.length - 1; i >= 0; i--) {
                      
                    text = text.concat( constraintText(queryObj.constraints[i]) )
                }
            }
        }
          
        $messageArea.html(text);
        if ( text.length != 0 ) {
            $("#query-area").slideDown();
        } else {
            $("#query-area").slideUp();
        }
    }

    /*
     * Given a constraint structure returns a human-readable text for it
     */
    function constraintText( constr ) {
        var value = '',
          out = '<span class="constraint-type">';
        
        switch (constr.type) {
         case 'category':
             out = out.concat('Occurrence Category');
             break;
         case 'occurrence':
             out = out.concat('Occurrence ');
             out = out.concat( constraintValueText( 'occurrence-property-name', constr.name ) );
             break;
         case 'object-property':
             out = out.concat( constraintValueText( 'object-property-name', constr.name ) );
             break;
        }
        
        out = out.concat('</span> <span class="constraint-operator">');
        
        switch (constr.operator) {
         case '=':
             out = out.concat('is equal to');
             break;
         case '!=':
             out = out.concat('is not');
             break;
         case 'LIKE':
             out = out.concat('contains');
             break;
         case 'NOT LIKE':
             out = out.concat('does not contain');
             break;
         case 'IN':
             out = out.concat('is one of: ');
             break;
         case 'NOT IN':
             out = out.concat('is not among: ');
             break;
             
         case 'ANY':
             out = out.concat('has one those properties: ');
             break;
         case 'ALL':
             out = out.concat('has all those properties:');
             break;
         case 'NONE':
             out = out.concat('has none of those properties:');
             break;
        }
        
        var value_text = constraintValueText( constr.type, constr.value );
        out = out.concat('</span> <span class="constraint-value">'+value_text+'</span> ');
        
        
        return out.concat("<br>");
    }
    
    
    /*
     * Given a constraint type and an value (or an array of values) retrives a
     * more human-readable value/
     */
    function constraintValueText(type, values) {
        var selectEl = null, valueText = '';

        console.log("---- "+type+" - "+values+" ----");
        
        switch (type) {
         case 'category':
             selectEl = document.getElementById('category-id');
             break;
             
         case 'occurrence-property-name':
             selectEl = document.getElementById('occurrence-prop-type');
             break;
         
         case 'object-property-name':
             selectEl = document.getElementById('object-prop-type');
             break;
         
         case 'object-property':
             selectEl = document.getElementById('object-prop-id');
             break;
             
         default:
             return values;
        }
        
        var options = [];
        for (var i = selectEl.options.length - 1; i >= 0; i--) {
            options[ selectEl.options[i].value ] = selectEl.options[i].text;
        }
        console.log('Options:');
        console.log(options);
        
        if ( typeof(values) === 'string' || typeof(values) === 'number' ) {
            valueText = options[ values ];
        } else {
            for (var i = values.length - 1; i >= 0; i--) {
                valueText = valueText.concat( options[ values[i] ]);
                if (i > 0) {
                    valueText = valueText.concat(', ');
                }
            }
        }
        
        return valueText;
    }
    
   
   
    function showAlertBox(options) {
        var setup = {
            closeIcon: '<a href="#" class="close">&times;</a>',
            // Remove (or not) old messages.
            cleanup: true,
            // Scrolls (or not) to the message area.
            scroll: true,
            // selecgtor where to append the message
            destination: ".content-wrapper .messages-region",
            // Type of the alert box: "success", "warning", "info", "alert",
            //  "secondary", "error" or empty string for default box
            type: 'error',
            // Actual message to display in the box
            message: 'Unexpected Error.'
        };
        jQuery.extend( setup, options );
        
        if ( setup.cleanup ) {
            $( setup.destination + " .ajax-alert").remove();
        }
        
        // Creating and adding the message box
        $("<div/>").attr({
            'data-alert': true,
            'class': 'ajax-alert alert-box radius ' + setup.type,
        // }).html( '<h4>' + setup.title + '</h4>' + setup.message )
        }).text( setup.message )
        .append( setup.closeIcon )
        .appendTo( setup.destination );
        
        if ( setup.scroll ) {
            $('html, body').animate({
                scrollTop: $(".title-region").offset().top
            }, 'slow');
        }
    }

});
