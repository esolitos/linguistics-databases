@extends("common.layout")
@section("content")
	<h2>Double Object Database</h2>
	<p>Database of duble object structures in Croatian</p>

	<h3>Create new Object Property</h3>
  {{ Form::open(array('action' => 'ObjectPropertyController@store')) }}

  {{ Form::field_error('name', $errors) }}
  {{ Form::label('name', 'Property Name'); }}
  {{ Form::text('name') }}

  
  {{ Form::submit('Save Changes') }}
  {{ Form::close() }}

@stop