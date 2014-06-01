@extends("common.layout")
@section("content")
  <h3>Viewing Occurrence: {{ $occurrence->id }}</h3>
  <h6 class="subheader">Category: {{ OccurrenceCategory::allForSelect()[$occurrence->category_id] }}</h6>
  <div class="show-occurrence occurrence-objects">
    <div class="row">
      <p class="small-12 columns"><strong>Text:</strong> <span class="occurrence-text">{{ $occurrence->text }}</span></p>
      <div class="small-12 columns">
        <div class="row">
          <span class="small-12 medium-2 large-2 columns"><strong>Verb:</strong> {{ $occurrence->verb }}</span>
          <span class="small-12 medium-3 large-2 columns"><strong>Keyword:</strong> {{ $occurrence->keyword }}</span>
          <span class="small-12 medium-3 large-2 columns"><strong>Speaker:</strong> {{ Occurrence::validSpeakers()[$occurrence->speaker] }}</span>
          <span class="small-12 medium-4 large-4 columns end"><strong>Coprus:</strong> {{$occurrence->corpus_file}}:{{$occurrence->corpus_row}}</span>
        </div>
      </div>
    </div>
    <hr>
    <h5 class="panel-title">Direct Object Properties ({{count($occurrence->propertyIDs('DIR'))}})</h5>
    <div class="row panel">
      <div class="small-12 columns">
        <ul class="inline-list object-properties-list">
          @foreach(ObjectProperty::find($occurrence->propertyIDs('DIR')) as $item)
            <li>{{$item->name}}</li>
          @endforeach
        </ul>
      </div>
    </div>
    <h5 class="panel-title">Indirect Object Properties ({{count($occurrence->propertyIDs('IND'))}})</h5>
    <div class="row panel">
      <div class="small-12 columns">
        <ul class="inline-list object-properties-list">
          @foreach(ObjectProperty::find($occurrence->propertyIDs('IND')) as $item)
            <li>{{$item->name}}</li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
  
  <div class="form-actions">
    <div class="button-bar">
      <ul class="button-group round">
        <li>{{ link_to_action('OccurrenceController@index', '&larr; Back to list', null, ['class'=>"button small secondary"]) }}</li>
      </ul>
      <ul class="button-group radius">
        <li>{{ link_to_action('OccurrenceController@edit', 'Edit Occurrence', $occurrence->id, ['class'=>"button small"]) }}</li>
        <li>{{ link_to_action('OccurrenceController@defineObjectProperties', 'Set Properties', $occurrence->id, ['class'=>"button small"]) }}</li>
        <li>{{ link_to_route('occurrence.delete', 'Delete', $occurrence->id, ['class'=>"button small alert"]) }}</li>
                

      </ul>
    </div>
  </div>
  
@stop