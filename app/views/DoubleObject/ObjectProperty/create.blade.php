@extends("DoubleObject.layout")
@section("content")

  <h3 class="subheader">Property Definition</h3>
  {{ Form::open(array('action' => 'ObjectPropertyController@store')) }}

  <div class="small-12 columns">
    {{ Form::label_item_error('text', 'name', "Property Name", null, $errors) }}
  </div>

  <div class="form-actions">
    {{ Form::submit('Careate &rarr;', ['class'=>"small button"]) }}
  </div>
  {{ Form::close() }}

@stop