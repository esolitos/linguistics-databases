@extends("common.layout")
@section("content")
	<h2>Double Object Database</h2>
	<p>Database of duble object structures in Croatian</p>

	<h3>Create new Occurrence</h3>
  {{ Form::open(array('action' => 'OccurrenceController@store')) }}

  {{ Form::field_error('category_id', $errors) }}
  {{ Form::label('category_id', 'Occurrence Category'); }}
  {{ Form::select('category_id', OccurrenceCategory::allForSelect([''=>"-Select One-"])) }}

  {{ Form::field_error('text', $errors) }}
  {{ Form::label('text', 'Text'); }}
  {{ Form::text('text'); }}<br>
    
  {{ Form::field_error('verb', $errors) }}
  {{ Form::label('verb', 'Verb'); }}
  {{ Form::text('verb'); }}<br>
  
  {{ Form::field_error('keyword', $errors) }}
  {{ Form::label('keyword', 'Keyword'); }}
  {{ Form::text('keyword'); }}<br>
  
  {{ Form::label('speaker', 'Speaker'); }}
  {{ Form::select('speaker', Occurrence::validSpeakers() ) }}
  
  <h4>Corpus Location</h4>
  {{ Form::field_error('corpus_file', $errors) }}
  {{ Form::label('corpus_file', 'File'); }}
  {{ Form::text('corpus_file'); }}<br>
  
  {{ Form::field_error('corpus_row', $errors) }}
  {{ Form::label('corpus_row', 'Row'); }}
  {{ Form::text('corpus_row'); }}<br>

  
  {{ Form::submit('Save and continue &rarr;', ['class'=>'button small']) }}
  {{ Form::submit('Save and define properties &rarr;', ['class'=>'button small']) }}
  {{ Form::close() }}

@stop