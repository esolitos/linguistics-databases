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
  {{ Form::select('first_object', CategoryObject::allForSelect(), $category->first_object) }}
  
  <hr>
  {{ Form::field_error('second_object', $errors) }}
  {{ Form::label('second_object', 'Select second Object'); }}
  {{ Form::select('second_object', CategoryObject::allForSelect(['none'=>"None"]), $category->second_object ) }}

  
  {{ Form::submit('Create &rarr;') }}
  {{ Form::close() }}

@stop