@extends("DoubleObject.layout")
@section("content")
  
  <div class="clearfix">
    {{ Form::open() }}
    
    <div class="small-12 large-3 columns">
      {{ Form::withLabel('property', "Select a Property")->select('property', ObjectProperty::allForSelect()) }}
    </div>
    
    <div class="small-12 large-3 columns end">
      {{ Form::submit('Show Result', ['class'=>'small button']) }}
    </div>
    
    {{ Form::close() }}
  </div>
  
  @if( !empty($related) )
    <div class="row">
      <div class="small-12 columns">
        <h5 class="subheader">Properties Related to: {{ $related_source }}</h5>
      </div>
      <div class="small-12 columns">
        
        <table id="related-properties-listing" class="display properties-listing">
        <thead>
          <tr>
            <th class="id">&nbsp;</th>
            <th class="name">&nbsp;</th>
            <th>First Object</th>
            <th>Second Object</th>
          </tr>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th colspan="2">Frequency</th>
          </tr>
        </thead>
        <tbody>
          @foreach($property_IDs as $pID=>$name)
            @if( isset($related['first'][$pID]) || isset($related['second'][$pID]) )
              <tr class="prop-id-{{$pID}} {{ ($pID%2) ? "odd" : "even" }}">
                <td>{{ $pID }}</td>
                <td>{{ ucwords($name) }}</td>
                <td>{{ $related['first'][$pID] or "&nbsp;" }}</td>
                <td>{{ $related['second'][$pID] or "&nbsp;" }}</td>
              </tr>
            @endif
          @endforeach
        </tbody>
        </table>
        
      </div>
    </div>  
  @endif

@stop
