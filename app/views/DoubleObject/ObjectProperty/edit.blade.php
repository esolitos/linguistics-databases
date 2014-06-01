@extends("common.layout")
@section("content")

	<h3>Edit Property: {{ $property->id }}</h3>
  {{ Form::open(array('action' => ['ObjectPropertyController@update', $property->id], 'method' => 'PATCH')) }}

  {{ Form::label('name', 'Property Name'); }}
  {{ Form::text('name', $property->name) }}
  {{ Form::field_error('name', $errors) }}

  <div class="form-actions">
    {{ Form::submit('Save Changes', ['class'=>"button"]) }}
  </div>
  
  {{ Form::close() }}

@stop