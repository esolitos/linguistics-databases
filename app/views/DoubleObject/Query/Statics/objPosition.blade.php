@extends("DoubleObject.layout")
@section("content")
  
  <div class="clearfix">
    {{ Form::open() }}
    
    <div class="small-12 medium-5 large-3 columns">
      {{ Form::withLabel('obj_type', "Type")->select('obj_type', CategoryObject::validObjectTypes()) }}
    </div>
    
    <div class="small-12 medium-5 large-3 columns">
      {{ Form::withLabel('obj_pos', "Position")->select('obj_pos', ['first'=>'First', 'second'=>'Second']) }}
    </div>
    
    <div class="small-12 medium-2 large-2 columns end">
      {{ Form::submit('Show Result', ['class'=>'small button']) }}
    </div>
    
    {{ Form::close() }}
  </div>

@stop
