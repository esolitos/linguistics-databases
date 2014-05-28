@extends("common.layout")
@section("content")
	<h2>Double Object Database</h2>
	<p>Database of duble object structures in Croatian</p>

	<h3>Create new Category</h3>
  {{ Form::open(array('action' => 'CategoryController@store')) }}
  @if( $errors->any() )
    {{ var_dump($errors) }}
  @endif

  {{ Form::field_error('first_object', $errors) }}
  {{ Form::label('first_object', 'Select first Object'); }}
  {{ Form::select('first_object', CategoryObject::allForSelect(['new'=>"Define New"])) }}
  &hellip; if not present define e new combination:<br>
  {{ Form::field_error('obj1_type', $errors) }}
  {{ Form::select('obj1_type', CategoryObject::validObjectTypes()) }}
  {{ Form::select('obj1_form', CategoryObject::validObjectForms()) }}
  {{ Form::select('obj1_decl', CategoryObject::validObjectDeclinations()) }}
  <div>{{ Form::form_checkbox('obj1_prep', 1, 'Has Preposition') }}</div>
  
  <hr>
  {{ Form::field_error('second_object', $errors) }}
  {{ Form::label('second_object', 'Select second Object'); }}
  {{ Form::select('second_object', CategoryObject::allForSelect(['none'=>"None", 'new'=>"Define New"]) ) }}
  
  &hellip; if not present define e new combination:<br>
  {{ Form::field_error('obj2_type', $errors) }}
  {{ Form::select('obj2_type', CategoryObject::validObjectTypes()) }}
  {{ Form::select('obj2_form', CategoryObject::validObjectForms()) }}
  {{ Form::select('obj2_decl', CategoryObject::validObjectDeclinations()) }}

  <div>{{ Form::form_checkbox('obj2_prep', 1, 'Has Preposition') }}</div>

  
  {{ Form::submit('Create &rarr;') }}
  {{ Form::close() }}

@stop