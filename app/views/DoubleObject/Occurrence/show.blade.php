@extends("common.layout")
@section("content")
	<h2>Double Object Database</h2>
	<p>Database of duble object structures in Croatian</p>

	<h3>
    Viewing Occurrence: {{ $occurrence->id }}<br>
    <small>Corpus Location: {{$occurrence->corpus_file}}:{{$occurrence->corpus_row}}</small>
  </h3>
  <div class="show-occurrence occurrence-objects">
    <div class="row">
      <p class="small-12 columns"><strong>Text:</strong> {{ $occurrence->text }}</p>
      <div class="small-12 columns">
        <span class="small-4 large-2 columns"><strong>Verb:</strong> {{ $occurrence->verb }}</span>
        <span class="small-4 large-2 columns"><strong>Keyword:</strong> {{ $occurrence->verb }}</span>
        <span class="small-4 large-2 columns end"><strong>Speaker:</strong> {{ $occurrence->verb }}</span>
      </div>
    </div>
    <hr>
    <div class="row">
      <h5 class="small-12 columns">First Object: <strong>{{ CategoryObject::validObjectTypes()[$occurrence->category->firstObj->type] }}</strong></h5>
      
      <span class="small-4 large-3 columns"><em>From</em>: {{ CategoryObject::validObjectForms()[$occurrence->category->firstObj->form] }}</span>
      <span class="small-4 large-3 columns"><em>Declination</em>: {{ CategoryObject::validObjectDeclinations()[$occurrence->category->firstObj->declination] }}</span>
      <span class="small-12 large-3 columns end"><em>Preposition</em>: {{ ($occurrence->category->firstObj->has_preposition) ? 'Yes' : 'No' }}</span>
      
      <div class="small-12 columns">
        <ul class="inline-list">
            <li><strong>Properties:</strong></li>
        @foreach(ObjectProperty::find($occurrence->propertyIDs($occurrence->category->firstObj->type)) as $item)
            <li>{{$item->name}}</li>
        @endforeach
        </ul>
      </div>
    </div>
    <div class="row">
      <h5 class="small-12 columns">First Object: <strong>{{ CategoryObject::validObjectTypes()[$occurrence->category->secondObj->type] }}</strong></h5>
      
      <span class="small-4 large-3 columns"><em>From</em>: {{ CategoryObject::validObjectForms()[$occurrence->category->secondObj->form] }}</span>
      <span class="small-4 large-3 columns"><em>Declination</em>: {{ CategoryObject::validObjectDeclinations()[$occurrence->category->secondObj->declination] }}</span>
      <span class="small-12 large-3 columns end"><em>Preposition</em>: {{ ($occurrence->category->secondObj->has_preposition) ? 'Yes' : 'No' }}</span>
      
      <div class="small-12 columns">
        <ul class="inline-list">
            <li><strong>Properties:</strong></li>
        @foreach(ObjectProperty::find($occurrence->propertyIDs($occurrence->category->secondObj->type)) as $item)
            <li>{{$item->name}}</li>
        @endforeach
        </ul>
      </div>
    </div>

  </div>
  <div class="occurrence-actions">
    <h4>Actions</h4>
    <div class="button-bar">
      <ul class="button-group round">
        <li>{{ link_to_action('OccurrenceController@index', 'Go to List', null, ['class'=>"button small secondary"]) }}</li>
      </ul>
      <ul class="button-group radius">
        <li>{{ link_to_action('OccurrenceController@edit', 'Edit Occurrence', $occurrence->id, ['class'=>"button small"]) }}</li>
        <li>{{ link_to_action('OccurrenceController@defineObjectProperties', 'Set Properties', $occurrence->id, ['class'=>"button small"]) }}</li>
        <li>{{ link_to_action('OccurrenceController@destroy', 'Delete', $occurrence->id, ['class'=>"button small alert"]) }}</li>
                

      </ul>
    </div>
  </div>
  
@stop