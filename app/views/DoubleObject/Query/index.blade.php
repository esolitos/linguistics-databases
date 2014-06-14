@extends("DoubleObject.layout")
@section("content")

<h2>Database Query</h2>
<h3 class="subheader">Executed queries: {{ $executed_queries }}</h3>

<div class="db-query-menu">
  <ul class="button-group">
    <li>{{ link_to_action('QueryController@getBuild', 'New Query', [], ['class'=>'button']) }}</li>
    <li>{{ link_to_action('QueryController@getBuild', 'New Query', [], ['class'=>'button']) }}</li>
    <li>{{ link_to_action('QueryController@getBuild', 'New Query', [], ['class'=>'button']) }}</li>
  </ul>
</div>
@stop