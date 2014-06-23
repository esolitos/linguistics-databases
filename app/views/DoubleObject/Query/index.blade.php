@extends("DoubleObject.layout")
@section("content")

  <div class="small-12 columns">
    <h3 class="subheader">Static Queries</h3>
    <p>Those queryes are fixed and it is only possible to change some small parameters, keep in mind that the results are updated only once every 6 hours.</p>
    <ul class="square">
      <li>Object Type/Position: {{ link_to_action('QueryController@anyStatic', 'View &rarr;', ['objects-position'], ['class'=>'tiny button radius']) }}</li>
      <li>Related Properties: {{ link_to_action('QueryController@anyStatic', 'View &rarr;', ['related-properties'], ['class'=>'tiny button radius']) }}</li>
      <li>Same Properties: {{ link_to_action('QueryController@anyStatic', 'View &rarr;', ['same-property'], ['class'=>'tiny button radius']) }}</li>
    </ul>
    <h3 class="subheader">Dynamic Queries</h3>
    <ul class="button-group">
      <li>{{ link_to_action('QueryController@getBuild', 'New Dynamic Query', [], ['class'=>'button']) }}</li>
    </ul>
  </div>
  
  <div class="small-12 columns">
    <h5 class="subheader">Fun Fact</h5>
    <p>Up until today I have compiled and executed <strong>{{ $executed_queries }} queries!</strong></p>
  </div>
@stop