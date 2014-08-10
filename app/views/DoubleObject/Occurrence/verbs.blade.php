@extends("DoubleObject.layout")
@section("content")
  
  @if( !empty($verbs) )
    <div class="row">
      <div class="small-12 columns">
        
        <table id="verbs-listing" class="display verbs-listing">
        <thead>
          <tr>
            <th>Verb</th>
            <th>Occ. Count</th>
            <th class="action">&nbsp;</th>
            <th class="action">&nbsp;</th>
          </tr>
        </thead>
        <tbody>
          @foreach($verbs as $i=>$aVerb)
            <tr class="{{ ($i%2) ? "odd" : "even" }}">
              <td>{{ ucwords($aVerb['verb']) }}</td>
              <td>{{ $aVerb['count'] }}</td>
              <td class="action view">{{ link_to_action("OccurrenceController@getBy", '&nbsp;',['verb', $aVerb['verb']], ['class'=>'fi-list-bullet actions view-occurrences', 'title'=>"View Occurrences"]) }}</td>
              <td class="action view">{{ link_to_action("QueryController@anyPropertyDistribution", '&nbsp;',['verb', $aVerb['verb']], ['class'=>'fi-graph-bar actions', 'title'=>"View Occurrences"]) }}</td>
            </tr>
          @endforeach
        </tbody>
        </table>
        
      </div>
    </div>  
  @endif

@stop
