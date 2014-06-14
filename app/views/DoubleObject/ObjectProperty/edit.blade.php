@extends("DoubleObject.layout")
@section("content")

  {{ Form::open(array('action' => ['ObjectPropertyController@update', $property->id], 'method' => 'PATCH')) }}

  <div class="small-12 columns">
    {{ Form::label_item_error('text', 'name', "Property Name", $property->name, $errors) }}
  </div>
  
  <div class="form-actions">
    {{ link_to_action("ObjectPropertyController@index", 'Cancel', null, ['class'=>"small button secondary"]) }}
    {{ Form::submit('Save Changes', ['class'=>"small button"]) }}
  </div>
  
  {{ Form::close() }}

@stop