@extends("DoubleObject.layout")
@section("content")
  
  <h3 class="subheader">Category Definition</h3>
  {{ Form::open(array('action' => 'CategoryController@store')) }}

  <div class="small-12 columns">    
    {{ Form::label_select_error('first_object_id', "Select first Object", CategoryObject::allForSelect([''=>"Select One", 'new'=>"Define New"]), $errors) }}    
  </div>
  
  <div class="small-12 columns panel hide" id="first_object_panel">
    <div class="small-12 columns">
      <p>&hellip; if not present define e new combination:</p>
    </div>
    <div class="small-6 medium-4 large-3 columns">
      {{ Form::select('obj1_type', CategoryObject::validObjectTypes()) }}
    </div>
    <div class="small-6 medium-4 large-3 columns">
      {{ Form::select('obj1_form', CategoryObject::validObjectForms()) }}
    </div>
    <div class="small-6 medium-4 large-3 columns">
      {{ Form::select('obj1_decl', CategoryObject::validObjectDeclinations()) }}
    </div>
    <div class="small-6 medium-4 large-3 columns">
      {{ Form::form_checkbox('obj1_prep', 1, 'Has Preposition') }}
    </div>
    <div class="small-12 columns">
      {{ Form::field_error('obj1_type', $errors) }}
    </div>
  </div>
  
  <div class="small-12 columns">
    {{ Form::label_select_error('second_object_id', "Select second Object", CategoryObject::allForSelect(['none'=>"None", 'new'=>"Define New"]), $errors) }}
  </div>
  
  <div class="small-12 columns panel hide" id="second_object_panel">
    <div class="small-12 columns">
      <p>&hellip; if not present define e new combination:</p>
    </div>
    <div class="small-6 medium-4 large-3 columns">
      {{ Form::select('obj2_type', CategoryObject::validObjectTypes()) }}
    </div>
    <div class="small-6 medium-4 large-3 columns">
      {{ Form::select('obj2_form', CategoryObject::validObjectForms()) }}
    </div>
    <div class="small-6 medium-4 large-3 columns">
      {{ Form::select('obj2_decl', CategoryObject::validObjectDeclinations()) }}
    </div>
    <div class="small-6 medium-4 large-3 columns">
      {{ Form::form_checkbox('obj2_prep', 1, 'Has Preposition') }}
    </div>
    <div class="small-12 columns">
      {{ Form::field_error('obj2_type', $errors) }}
    </div>
  </div>

  <div class="form-actions">
    {{ Form::submit('Create &amp; continue', ['class'=>'small button', 'name'=>'submit-continue']) }}
    {{ Form::submit('Create &amp; Insert Occurrences &rarr;', ['class'=>'small button secondary', 'name'=>'submit-insert']) }}
  </div>
  {{ Form::close() }}

@stop