@extends("DoubleObject.layout")
@section("content")

	<h3>Edit Category: {{ $category->id }}</h3>
  {{ Form::open(array('action' => ['CategoryController@update', $category->id], 'method' => 'PATCH')) }}

  <div class="row">
    <div class="small-12 medium-6 columns">
      {{ Form::label('first_object_id', 'Select first Object'); }}
      {{ Form::select('first_object_id', CategoryObject::allForSelect(), $category->first_object_id) }}
      {{ Form::field_error('first_object_id', $errors) }}
    </div>
  
    <div class="small-12 medium-6 columns">
      {{ Form::label('second_object_id', 'Select second Object'); }}
      {{ Form::select('second_object_id', CategoryObject::allForSelect(['none'=>"None"]), $category->second_object_id ) }}
      {{ Form::field_error('second_object_id', $errors) }}
    </div>
  </div>

  <div class="form-actions">
    {{ Form::submit('Save Changes', ['class'=>'button']) }}
  </div>
  {{ Form::close() }}

@stop