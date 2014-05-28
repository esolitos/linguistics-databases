@extends("common.layout")
@section("content")
	<h2>Double Object Database</h2>
	<p>Database of duble object structures in Croatian</p>

	<h3>Edit Property: {{ $property->id }}</h3>
  {{ Form::open(array('action' => ['ObjectPropertyController@update', $property->id], 'method' => 'PATCH')) }}

  {{ Form::field_error('name', $errors) }}
  {{ Form::label('name', 'Property Name'); }}
  {{ Form::text('name', $property->name) }}

  
  {{ Form::submit('Save Changes') }}
  {{ Form::close() }}

@stop