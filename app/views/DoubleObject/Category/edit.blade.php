@extends("common.layout")
@section("content")
	<h2>Double Object Database</h2>
	<p>Database of duble object structures in Croatian</p>

	<h3>Create new Category</h3>
  {{ Form::open(array('action' => ['CategoryController@update', $category->id], 'method' => 'PATCH')) }}
  @if( $errors->any() )
    {{ var_dump($errors) }}
  @endif

  {{ Form::field_error('first_object_id', $errors) }}
  {{ Form::label('first_object_id', 'Select first Object'); }}
  {{ Form::select('first_object_id', CategoryObject::allForSelect(), $category->first_object_id) }}
  
  <hr>
  {{ Form::field_error('second_object_id', $errors) }}
  {{ Form::label('second_object_id', 'Select second Object'); }}
  {{ Form::select('second_object_id', CategoryObject::allForSelect(['none'=>"None"]), $category->second_object_id ) }}

  
  {{ Form::submit('Create &rarr;') }}
  {{ Form::close() }}

@stop