@extends("common.layout")
@section("content")
	<h2>Double Object Database</h2>
	<p>Database of Duble Object structures in Croatian<br><em>TODO: Insert better Description.</em></p>

	<h4>Available Actions</h4>
	<ul>
		<li><a href="{{ action('CategoryController@create') }}">Create New <em>Category</em></a>: you will define a new "Occurrence Category", like for example: <em>DO-IO (NP-CL) on give</em></li>
		<li><a href="{{ action('ObjectPropertyController@create') }}">Insert New <em>Object Property</em></a>: you will define a new "Property" that will subsequently used in the Occurrence insertion.</li>
		<li><a href="{{ action('OccurrenceController@create') }}">Insert New Occurrence</a>: define a new Occurrence/Istance in a specific Category and its Objects' properties.<br><small>(Note that the <u>Occurrence Category</u> and <u>Object Properties</u> must of this Occurrence <strong>must be already defined</strong>!)</small></li>
		<li><a href="occurrences.php">Define Object Properties</a>: define the Object's Properties of an Occurrence.</li>
		<li class="separator"></li>
		<li><a href="custom_query.php">Make a <strong>custom interrogation</strong> to the Database <em>(expert mode)</em>.</a></li>
	</ul>
@stop