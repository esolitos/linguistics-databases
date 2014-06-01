@extends("common.layout")
@section("content")

	<h3>Define Object's Properties for Occurrence: {{ $occurrence->id }}</h3>  
  <div class="row property-definition-data category">
    <strong class="small-3 medium-2 columns">Category:</strong><span>{{ OccurrenceCategory::allForSelect()[$occurrence->category->id] }}</span>
  </div>
  <div class="row property-definition-data text">
    <strong class="small-3 medium-2 columns">Text:</strong><span>{{{ $occurrence->text }}}</span>
  </div>
  <div class="row property-definition-data verb">
    <strong class="small-3 medium-2 columns">Verb:</strong><span>{{{ $occurrence->verb }}}</span>
  </div>
  <div class="row property-definition-data keyword">
    <strong class="small-3 medium-2 columns">Keyword:</strong><span>{{{ $occurrence->keyword }}}</span>
  </div>
  <div class="row property-definition-data speaker">
    <strong class="small-3 medium-2 columns">Speaker:</strong><span>{{{ Occurrence::validSpeakers()[$occurrence->speaker] }}}</span>
  </div>
  <div class="row property-definition-data corpus">
    <strong class="small-3 medium-2 columns">Corpus Location:</strong><span>{{ $occurrence->corpus_file }}:{{ $occurrence->corpus_row }}</span>
  </div>
  <br>
  
  {{ Form::open(array('action' => ['OccurrenceController@storeObjectProperties', $occurrence->id], 'method' => 'POST')) }}
  <h4>Direct Object Properties</h4>
  <label>Check the properties that the <strong>Direct object</strong> has.</label>
  <ul class="small-block-grid-2 medium-block-grid-4 large-block-grid-6">
    @foreach(ObjectProperty::all() as $item)
        <li> {{ Form::form_checkbox('direct_properties[]', $item->id, $item->name, false, ['id'=>"direct-property-{$item->id}"])  }} </li>
    @endforeach
  </ul>
  <h4>Indirect Object Properties</h4>
  <label>Check the properties that the <strong>Indirect object</strong> has.</label>
  <ul class="small-block-grid-2 medium-block-grid-4 large-block-grid-6">
    @foreach(ObjectProperty::all() as $item)
        <li> {{ Form::form_checkbox('indirect_properties[]', $item->id, $item->name, false, ['id'=>"indirect-property-{$item->id}"])  }} </li>
    @endforeach
  </ul>
  
  <p class="row">
    {{ Form::submit('Save Properties', ['class'=>'button small']) }}
  </p>
  {{ Form::close() }}

@stop