@extends("common.layout")
@section("content")
	<h3>Create new Category</h3>
  {{ Form::open(array('action' => 'CategoryController@store')) }}

  <div class="row">
    <div class="small-12 columns">
      {{ Form::label('first_object_id', 'Select first Object'); }}
      {{ Form::select('first_object_id', CategoryObject::allForSelect([''=>"Select One", 'new'=>"Define New"])) }}
      {{ Form::field_error('first_object_id', $errors) }}
    </div>
  </div>
  
  <div class="panel row hide">
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
  
  <div class="row">
    <div class="small-12 columns">
      {{ Form::label('second_object_id', 'Select second Object'); }}
      {{ Form::select('second_object_id', CategoryObject::allForSelect(['none'=>"None", 'new'=>"Define New"]) ) }}
      {{ Form::field_error('second_object_id', $errors) }}
    </div>
  </div>
  
  <div class="panel row hide">
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
    {{ Form::submit('Create &rarr;', ['class'=>'button']) }}
  </div>
  {{ Form::close() }}

@stop