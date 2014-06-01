@extends("common.layout")
@section("content")

	<h3>Create new Object Property</h3>
  {{ Form::open(array('action' => 'ObjectPropertyController@store')) }}

  {{ Form::label('name', 'Property Name'); }}
  {{ Form::text('name') }}
  {{ Form::field_error('name', $errors) }}

  <div class="form-actions">
    {{ Form::submit('Careate &rarr;', ['class'=>"button"]) }}
  </div>
  {{ Form::close() }}

@stop