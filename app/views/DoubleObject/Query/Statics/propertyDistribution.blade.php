@extends("DoubleObject.layout")
@section("content")
  
  <div class="clearfix">
    {{ Form::open() }}
    
    <div class="small-12 large-4 columns">
      {{ Form::withLabel('categories[]', "Select the Categories to show")->select('categories[]', $categories, $selectedCategs, ['multiple'=>true, 'size'=>7]) }}
    </div>
    
    {{--
    <div class="small-12 large-3 columns">
      {{ Form::withLabel('properties[]', "Select the Properties to show")->select('properties[]', $properties, null, ['multiple'=>true, 'size'=>7]) }}
    </div>
    --}}
    
    <div class="small-12 large-3 columns">
      {{ Form::label('obj_type', "Object Type") }}
      @foreach($objectType as $key=>$label)
          {{ Form::withLabel('obj_type', $label)->radio('obj_type', $key, ($objectClass === $key)) }}
      @endforeach
    </div>
    
    <div class="small-12 large-3 columns">
      {{ Form::label('speaker', "Speaker") }}
      @foreach(Occurrence::validSpeakers() as $key=>$label)
          {{ Form::withLabel('speaker[]', $label)->checkbox('speaker[]', $key, (in_array($key, $selectedSpeakers))) }}
      @endforeach
    </div>
    
    <div class="small-12 large-2 columns end">
      {{ Form::submit('Show Result', ['class'=>'small button']) }}
    </div>
    
    {{ Form::close() }}
  </div>
  
  @if( isset($distribution) )
    <div class="row">
      <div class="small-12 columns">
        <h5 class="subheader">Distribution of the <strong>{{ $objectType[$objectClass] }} object</strong> properties for the verb: <em>{{ $selectedVerb or 'All Verbs' }}</em>.</h5>
      </div>
      <div class="small-12 columns">
      @if( !empty($distribution) )  
        <table id="property-distribution-listing" class="display property-distribution-listing">
        <thead>
          <tr>
            <th class="category"><span>Category</span><span>Property &rarr;<span></th>
            @foreach($properties as $propertyName)
              <th>{{ $propertyName }}</th>
            @endforeach
            <th><strong>Occurrences</strong></th>
          </tr>
        </thead>
        <tbody>
          @foreach($categories as $catID => $categoryName )
            @if( isset($distribution[$catID]) )
            <tr class="category cat-{{$catID}}">
              <td class="category-name">{{ $categoryName }}</td>

              @foreach($properties as $propID=>$propertyName)
                <td class="property-count property-{{$propID}}">
                @if( !empty($distribution[$catID][$propID]) )
                  <?php $query_args = [
                    'category'    => $catID,
                    'property'    => $propID,
                    'object'      => $objectClass,
                    'speaker'     => implode(',', $selectedSpeakers),
                  ]; ?>
                  <a href="{{ action('QueryController@getPropertyDistributionOccurrences') .'?'. http_build_query($query_args) }}">
                    {{ $distribution[$catID][$propID]['count'] }}<br/>
                    <em>{{ $distribution[$catID][$propID]['percent'] }}%</em>
                  </a>
                @else
                   &bull;
                @endif
                </td>
              @endforeach
              
              <td>
                <?php $query_args = [
                        'category'    => $catID,
                        'object'      => $objectClass,
                        'speaker'     => implode(',', $selectedSpeakers),
                ]; ?>
                <em><a href="{{ action('QueryController@getPropertyDistributionOccurrences') .'?'. http_build_query($query_args) }}">View all:<br>{{ $distribution['total'][$catID] }}</a></em>
              </td>
            </tr>
            @endif
          @endforeach
        </tbody>
        </table>
      @else
        <p>There are no properties for the given constraints.</p>
      @endif
      </div>
    </div>
  @endif


@stop
