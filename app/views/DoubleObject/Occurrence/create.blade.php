@extends("common.layout")
@section("content")

  <h3>Create new Occurrence</h3>
  {{ Form::open(array('action' => 'OccurrenceController@store')) }}
  <div class="row">
    <div class="small-12 columns">
      {{ Form::label('category_id', 'Occurrence Category'); }}
      {{ Form::select('category_id', OccurrenceCategory::allForSelect([''=>"-Select One-"])) }}
      {{ Form::field_error('category_id', $errors) }}
    </div>

    <div class="small-12 columns">
      {{ Form::label('text', 'Text'); }}
      {{ Form::text('text'); }}
      {{ Form::field_error('text', $errors) }}
    </div>
  
    <div class="small-12 medium-6 large-4 columns">
      {{ Form::label('verb', 'Verb'); }}
      {{ Form::text('verb'); }}
      {{ Form::field_error('verb', $errors) }}
    </div>
  
    <div class="small-12 medium-6 large-4 columns">
      {{ Form::label('keyword', 'Keyword'); }}
      {{ Form::text('keyword'); }}
      {{ Form::field_error('keyword', $errors) }}
    </div>
  
    <div class="small-12 medium-6 large-4 columns">
      {{ Form::label('speaker', 'Speaker'); }}
      {{ Form::select('speaker', Occurrence::validSpeakers() ) }}
      {{ Form::field_error('speaker', $errors) }}
    </div>

    <div class="small-12 medium-6 large-12 columns">
      <h4>Corpus Location</h4>
    
      <div class="row">
        <div class="small-6 columns">
          {{ Form::label('corpus_file', 'File'); }}
          {{ Form::text('corpus_file'); }}
          {{ Form::field_error('corpus_file', $errors) }}
        </div>
  
        <div class="small-6 columns">
          {{ Form::label('corpus_row', 'Row'); }}
          {{ Form::text('corpus_row'); }}
          {{ Form::field_error('corpus_row', $errors) }}
        </div>
      
      </div>
    </div>
  </div>
  
  <div class="form-actions">
    {{ Form::submit('Save and continue &rarr;', ['class'=>'button small']) }}
    {{ Form::submit('Save and define properties &rarr;', ['class'=>'button small', 'name'=>'set-properties']) }}
  </div>
  {{ Form::close() }}

@stop