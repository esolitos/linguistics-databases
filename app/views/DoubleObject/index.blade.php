@extends("DoubleObject.layout")
@section("content")

  <h4>Available Actions</h4>
  <ul>
    <li><a href="{{ action('CategoryController@create') }}">Create New <em>Category</em></a>: you will define a new "Occurrence Category", like for example: <em>DO/IO (NP/CL ACC/DAT)</em></li>
    <li><a href="{{ action('ObjectPropertyController@create') }}">Insert New <em>Object Property</em></a>: you will define a new "Property" that will subsequently used in the Occurrence insertion.</li>
    <li><a href="{{ action('OccurrenceController@create') }}">Insert New Occurrence</a>: define a new Occurrence/Istance in a specific Category and its Objects' properties.<br><small>(Note that the <u>Occurrence Category</u> and <u>Object Properties</u> must of this Occurrence <strong>must be already defined</strong>!)</small></li>
  </ul>

@stop