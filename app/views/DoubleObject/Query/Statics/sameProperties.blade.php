@extends("DoubleObject.layout")
@section("content")
  
  <div class="clearfix">
    {{ Form::open() }}
    
    <div class="small-12 large-3 columns">
      {{ Form::withLabel('property', "Select a Property")->select('property', ObjectProperty::allForSelect()) }}
    </div>

    <div class="small-12 large-3 columns">
      {{ Form::withLabel('reverse', "Negate search (aka Reverse)")->checkbox('reverse') }}
    </div>
    
    <div class="small-12 large-3 columns end">
      {{ Form::submit('Show Result', ['class'=>'small button']) }}
    </div>
    
    {{ Form::close() }}
  </div>

@stop
