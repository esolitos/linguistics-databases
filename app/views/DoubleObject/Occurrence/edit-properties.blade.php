@extends("DoubleObject.layout")
@section("content")

  <h3 class="subheader">Occurrence Data</h3>  
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
  
  {{ Form::open(array('action' => ['OccurrenceController@updateObjectProperties', $occurrence->id], 'method' => 'POST')) }}
  <h4 class="subheader">Direct Object Properties</h4>
  <label>Check the properties that the <strong>Direct object</strong> has.</label>
  <ul class="small-block-grid-2 medium-block-grid-4 large-block-grid-6">
    @foreach(ObjectProperty::all() as $item)
        <li> {{ Form::form_checkbox('direct_properties[]', $item->id, $item->name, in_array($item->id, $direct_properties), ['id'=>"direct-property-{$item->id}"])  }} </li>
    @endforeach
  </ul>
  <h4 class="subheader">Indirect Object Properties</h4>
  <label>Check the properties that the <strong>Indirect object</strong> has.</label>
  <ul class="small-block-grid-2 medium-block-grid-4 large-block-grid-6">
    @foreach(ObjectProperty::all() as $item)
        <li> {{ Form::form_checkbox('indirect_properties[]', $item->id, $item->name, in_array($item->id, $indirect_properties), ['id'=>"indirect-property-{$item->id}"])  }} </li>
    @endforeach
  </ul>
  
  <div class="form-actions">
    {{ link_to_action('OccurrenceController@index', 'Cancel', null, ['class'=>"small button secondary"]) }}
    {{ Form::submit('Save Changes', ['class'=>'button small']) }}
  </div>
  {{ Form::close() }}

@stop