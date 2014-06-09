@extends("common.layout")
@section("content")

<h2>Build New Query</h2>

<div class="db-query-menu">
  {{ Form::open([ 'action'=> "QueryController@postVerify" ]) }}
  
  <div id="query-build-area" class="row">
    <h3 class="small-12 columns subheader">Select Output</h3>
    <div class="small-12 medium-4 large-4 columns">
      <label>
        Load..
        {{ Form::select('category[id]', ['CAT'=>'Categories', 'OCC'=>'Occurrences', 'PROP'=>'Obj. Properties']) }}
      </label>
    </div>
    <div class="small-12 medium-4 large-4 columns">
      <label>
        ..and show me..
        {{ Form::select('category[id]', [ 'ALL'=>'Everything', 'NAME'=>'Names', 'COUNT'=>'Count']) }}
      </label>
    </div>
    <div class="small-12 medium-4 large-4 columns end">
      <a href="#" class="button small" id="add-output">Select Output</a>
    </div>
    <h3 class="small-12 columns subheader">Add Constriants</h3>

    <h5 class="small-12 columns subheader">Category Properties</h5>
    <div class="small-12 medium-4 large-4 columns">
      <label>Operator:{{ Form::select('category[op]', ['='=>'Equals', '!='=>'Is Not', 'IN'=>'In', 'NOT IN'=>'Not in']) }}</label>
    </div>
    <div class="small-12 medium-4 large-4 columns">
      <label>Category:{{ Form::select('category[id]', OccurrenceCategory::allForSelect()) }}</label>
    </div>
    <div class="small-12 medium-4 large-4 columns end">
      <a href="#" class="button small" id="add-category">Add Constraint</a>
    </div>
    
    <h5 class="small-12 columns subheader">Occurrence Properties</h5>
    <div class="small-12 medium-3 large-3 columns">
      <label>What: {{ Form::select('occurr_prop[type]', ['V'=>'Verb', 'K'=>'Keyword', 'T'=>'Text', 'C'=>'Corpus', 'S'=>'Speaker']) }}</label>
    </div>
    <div class="small-12 medium-3 large-3 columns">
      <label>Operator: {{ Form::select('occurr_prop[op]', ['='=>'Exact', 'LIKE'=>'Contains', '!='=>'Different', 'NOT LIKE'=>'Does not Contain']) }}</label>
    </div>
    <div class="small-12 medium-3 large-3 columns">
      <label>String: {{ Form::text('occurr_prop[val]'); }}</label>
    </div>
    <div class="small-12 medium-4 large-3 columns end">
      <a href="#" class="button small" id="add-category">Add Constraint</a>
    </div>
    
    
    <h5 class="small-12 columns subheader">Object Properties</h5>
    <div class="small-12 medium-3 large-3 columns">
      <label>What: {{ Form::select('occurr_prop[type]', ['DO'=>'Direct Object', 'IO'=>'Indirect Object', 'FO'=>'First Object', 'SO'=>'Second Object']) }}</label>
    </div>
    <div class="small-12 medium-3 large-3 columns">
      <label>Operator: {{ Form::select('occurr_prop[op]', ['+'=>'Has', '-'=>'Has Not', 'IN'=>'In', 'NOT IN'=>'Not In']) }}</label>
    </div>
    <div class="small-12 medium-3 large-3 columns">
      <label>Category:{{ Form::select('category[id]', ObjectProperty::allForSelect() ) }}</label>
    </div>
    <div class="small-12 medium-4 large-3 columns end">
      <a href="#" class="button small" id="add-category">Add Constraint</a>
    </div>



  </div>
  <div id="query-area" class="row">
    
  </div>
  
  <div class="form-actions">
    {{ link_to( URL::previous(), '&larr; Go Back', ['class'=>'button secondary']) }}
    {{ Form::submit('Verify Query', ['class'=>'button ']); }}
  </div>
  {{ Form::close() }}
</div>
@stop