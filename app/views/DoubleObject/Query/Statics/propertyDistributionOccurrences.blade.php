@extends("DoubleObject.layout")
@section("content")

<div class="row">
  <div class="small-12 columns">
    <h5 class="subheader">Distribution of the <strong>{{ $objectType }} object</strong> properties for the verb: <em>{{ $selectedVerb or 'All Verbs' }}</em>.</h5>
  </div>
  <div class="small-12 columns">
  @if( !empty($occurrences) )  
    <table id="property-distribution-occurrence-listing" class="display property-distribution-listing">
    <thead>
      <tr>
        <th class="category">Occurrence</th>
        <th></th>
        @foreach($properties as $propertyName)
          <th>{{ $propertyName }}</th>
        @endforeach
      </tr>
    </thead>
    <tbody>
      @foreach($occurrences->get() as $i=>$occ)
      @if( ($i+1)%10 === 0 )
        <tr>
          <td>Occurrence</td>
          <td></td>
          @foreach($properties as $propertyName)
            <td>{{ $propertyName }}</td>
          @endforeach
        </tr>
      @endif
        <tr class="row-{{$i}}">
          <td rowspan="2">{{ link_to_action('OccurrenceController@show', $occ->text, [$occ->id], ['class'=>"occurrence-text"]) }}</td>
          <td><strong>DIR</strong></td>
          <?php $props = $occ->propertyIDs('DIR') ?>
          @foreach($properties as $id=>$name)
            <td>{{ (in_array($id,$props)) ? '&#x2714;' : '' }}</td>
          @endforeach
        </tr>
        <tr>
          <td><strong>IND</strong></td>
          <?php $props = $occ->propertyIDs('IND') ?>
          @foreach($properties as $id=>$name)
            <td>{{ (in_array($id,$props)) ? '&#x2714;' : '' }}</td>
          @endforeach
        </tr>
      @endforeach
    </tbody>
    <tfoot>
      <tr>
        <th class="category">Occurrence</th>
        <th></th>
        @foreach($properties as $propertyName)
          <th>{{ $propertyName }}</th>
        @endforeach
      </tr>
    </thead>
    </table>
  @else
    <p>There are no properties for the given constraints.</p>
  @endif
  </div>
</div>

@stop
