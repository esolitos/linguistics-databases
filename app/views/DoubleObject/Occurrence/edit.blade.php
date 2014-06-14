@extends("DoubleObject.layout")
@section("content")



  <h3 class="subheader">Occurrence Data</h3>

  @if( $create )
    {{ Form::open(array('action' => 'OccurrenceController@store')) }}
  @else
    {{ Form::open(array('action' => ['OccurrenceController@update', $occurrence->id], 'method' => 'PATCH')) }}
  @endif
  
  <div class="row">
    <div class="small-12 columns">
      {{ Form::label_select_error('category_id', 'Occurrence Category', OccurrenceCategory::allForSelect([''=>"-Select One-"]), $errors, $occurrence->category_id) }}
    </div>

    <div class="small-12 columns">
      {{ Form::label_item_error('text', 'text', 'Text', $occurrence->text, $errors) }}
    </div>
  
    <div class="small-12 medium-6 large-4 columns">
      {{ Form::label_item_error('text', 'verb', 'Verb', $occurrence->verb, $errors) }}
    </div>
  
    <div class="small-12 medium-6 large-4 columns">
      {{ Form::label_item_error('text', 'keyword', 'Keyword', $occurrence->keyword, $errors) }}
    </div>
  
    <div class="small-12 medium-6 large-4 columns">
      {{ Form::label_select_error('speaker', 'Speaker', Occurrence::validSpeakers(), $errors, $occurrence->speaker) }}
    </div>

    <div class="small-12 medium-6 large-12 columns">
      <h4 class="subheader">Corpus Location</h4>
    
      <div class="row">
        <div class="small-6 columns">
          {{ Form::label_item_error('text', 'corpus_file', 'File', $occurrence->corpus_file, $errors) }}
        </div>
  
        <div class="small-6 columns">
          {{ Form::label_item_error('number', 'corpus_row', 'Row', $occurrence->corpus_row, $errors, ['autocomplete'=>'off']) }}
        </div>
      
      </div>
    </div>
  </div>

  <div class="form-actions">
    @if( $create )
      {{ link_to_action('OccurrenceController@index', '&larr; Back', null, ['class'=>"small button secondary"]) }}
      {{ Form::submit('Save and continue &rarr;', ['class'=>'button small']) }}
      {{ Form::submit('Save and define properties &rarr;', ['class'=>'button small secondary', 'name'=>'set-properties']) }}
    @else
      {{ link_to_action('OccurrenceController@show', 'Cancel', $occurrence->id, ['class'=>"small button secondary"]) }}
      {{ Form::submit('Save Changes', ['class'=>'button small']) }}
    @endif
  </div>
  
  {{ Form::close() }}

@stop