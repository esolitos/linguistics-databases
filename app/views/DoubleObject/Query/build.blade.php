@extends("DoubleObject.layout")
@section("content")

<h2>Build New Query</h2>

<div class="db-query-page">
  {{ Form::open([ 'action'=> "QueryController@postVerify", 'id'=>'db-query-form' ]) }}
  
  <div id="query-build-area" class="row">
    <fieldset id="select-output" class="output-selection-area">
      <legend>Select Output</legend>
      <p class="placeholder">
        Output style already selected, now you can add constraints.<br>
        <strong>Note</strong>: If you wish to chenge output type click on the follwing button, but be aware that you'll loose all defined constraints.<br>
        <a href="#" class="tiny button alert" id="mod-output">Modify Output</a>
      </p>
      <div class="options">
        <div class="small-12 medium-4 large-4 columns">
          <label>Output object: {{ Form::select('output-object', ['-1'=>'-Select-', 'CAT'=>'Categories', 'OCC'=>'Occurrences', 'PROP'=>'Obj. Properties']) }}</label>
        </div>
        <div class="small-12 medium-4 large-4 columns">
          <label>&hellip;with output style: {{ Form::select('output-type', [ 'ALL'=>'Everything', 'NAME'=>'Names', 'COUNT'=>'Count']) }}</label>
        </div>
        <div class="small-12 medium-4 large-4 columns end">
          <a href="#" class="button small" id="add-output">Select Output</a>
        </div>
      </div>
    </fieldset>
    
    
    <fieldset id="add-constraints" class="">
      <legend>Add Constriants</legend>
      <p class="placeholder">Select an output style before adding constraints.</p>
      <div class="options">
        
        <h5 class="small-12 columns subheader">Category Properties</h5>
        <div class="small-12 medium-3 large-3 columns">
          <label>&nbsp;{{ Form::text('.', "Occurrence Category", ['disabled'=>true]) }}</label>
        </div>
        <div class="small-12 medium-3 large-3 columns">
          <label>&nbsp;{{ Form::select('category-op', ['='=>'Equals', '!='=>'Is Not', 'IN'=>'In', 'NOT IN'=>'Not in']) }}</label>
        </div>
        <div class="small-12 medium-3 large-3 columns">
          <label>&nbsp;{{ Form::select('category-id', OccurrenceCategory::allForSelect(), null, ['id'=>"category-id"]) }}</label>
        </div>
        <div class="small-12 medium-3 large-3 columns end">
          <a href="#" class="button small" id="add-category">Add Constraint</a>
        </div>
        
        <h5 class="small-12 columns subheader">Occurrence Properties</h5>
        <div class="small-12 medium-3 large-3 columns">
          <label>What: {{ Form::select('occurrence-prop-type', ['V'=>'Verb', 'K'=>'Keyword', 'T'=>'Text', 'C'=>'Corpus', 'S'=>'Speaker'], null,['id'=>"occurrence-prop-type"]) }}</label>
        </div>
        <div class="small-12 medium-3 large-3 columns">
          <label>Operator: {{ Form::select('occurrence-prop-op', ['='=>'Exact', 'LIKE'=>'Contains', '!='=>'Different', 'NOT LIKE'=>'Does not Contain'], null, ['id'=>"occurrence-prop-op"]) }}</label>
        </div>
        <div class="small-12 medium-3 large-3 columns">
          <label>Value: {{ Form::text('occurrence-prop-value', null, ['id'=>"occurrence-prop-value"]) }}</label>
        </div>
        <div class="small-12 medium-4 large-3 columns end">
          <a href="#" class="button small" id="add-occurrence-prop">Add Constraint</a>
        </div>
        
        <h5 class="small-12 columns subheader">Object Properties</h5>
        <div class="small-12 medium-3 large-3 columns">
          <label>What: {{ Form::select('object-prop-type', ['DO'=>'Direct Object', 'IO'=>'Indirect Object', 'FO'=>'First Object', 'SO'=>'Second Object'], null, ['id'=>"object-prop-type"]) }}</label>
        </div>
        <div class="small-12 medium-3 large-3 columns">
          <label>Operator: {{ Form::select('object-prop-op', ['ALL'=>'Has All', 'ANY'=>'Has Any', 'NONE'=>'Does not have'], null, ['id'=>"object-prop-op"]) }}</label>
        </div>
        <div class="small-12 medium-3 large-3 columns">
          <label>Category:{{ Form::select('object-prop-id', ObjectProperty::allForSelect(), null, ['id'=>"object-prop-id", 'multiple'=>TRUE] ) }}</label>
        </div>
        <div class="small-12 medium-4 large-3 columns end">
          <a href="#" class="button small" id="add-object-prop">Add Constraint</a>
        </div>
      </div>
        
    </fieldset>



  </div>
  <fieldset id="query-area" class="">
    <legend>Query Info</legend>
    <p class="small-12 columns text"></p>
  </fieldset>
  
  <div class="form-actions">
    {{ link_to( URL::previous(), '&larr; Go Back', ['class'=>'button secondary']) }}
    <a href="#" class="button alert" id="verify-built-query">Verify Query</a>
    {{ Form::submit('Execute Query', ['class'=>'button disabled', 'disabled'=>TRUE]); }}
  </div>
  {{ Form::close() }}
</div>
<div class="hide script-area">
  <script type="text/javascript" src="/javascript/jquery.query-builder.js"></script>
</div>
@stop