@extends("DoubleObject.layout")
@section("content")

<h2>Database Statistics</h2>

<h3 class="subheader">Categories Analysis</h3>

<div class="statistics categories">
  <p>You have created <strong>{{ $categories->tot }} categories</strong> from which I was able to extract those information: </p>
  <ul>
    <li>Defined objects: {{ $categories->object_types }} <small>(as combination of Type+Form+Case)</small></li>
    <li>
      Both object specified: {{ $categories->double_object->tot }}
      <ul>
        <li>Direct object first: {{ count($categories->double_object->direct_first) }}</li>
        <li>Indirect object first: {{ count($categories->double_object->indirect_first) }}</li>
      </ul>
    </li>
    <li>
      Only first object specified: {{ $categories->single_object->tot }} 
      {{-- ( DIR: {{ $categories->single_object->direct }} / IND: {{ $categories->single_object->indirect }} ) --}}
      <ul>
        <li>Direct only: {{ $categories->single_object->direct }}</li>
        <li>Indirect only: {{ $categories->single_object->indirect }}</li>
      </ul>
    </li>
    <li><a href="#">Click here</a> and dig more into details. <em>(Coming Soon)</em></li>
  </ul>
</div>

<h3 class="subheader">Occurrences Analysis</h3>
<div class="statistics occurrence">
  <p>In the database there are curently <strong>{{ $occurrences->tot }} occurrences</strong> from wichi I was able to get those information: </p>
  <ul>
    <li>Average occurrences per category: {{ floor(array_sum($occurrences->per_category)/count($occurrences->per_category)) }}</li>
    <li>Average occurrences per verb: {{ floor(array_sum($occurrences->per_verb)/count($occurrences->per_verb)) }}</li>
    <li>Average occurrences per keyword: {{ floor(array_sum($occurrences->per_keyword)/count($occurrences->per_keyword)) }}</li>
    <li>
      Occurrences per verb: <small>(<strong>Coming Soon</strong>: Click the verb for view the occurrences.)</small>
      <ul>
        @foreach($occurrences->per_verb as $verb => $tot)
            <li><strong>{{ link_to_route('occurrence.get-by', $verb, ['verb', $verb]) }}</strong> -&gt; {{$tot}}</li>
        @endforeach
      </ul>
    </li>
    <li><a href="#">Click here</a> and dig more into details. <em>(Coming Soon)</em></li>
  </ul>

</div>

<h3 class="subheader">Properties Analisys</h3>
<div class="statistics properties">
  <p>There are currently <strong>{{ $properties->tot }} properties</strong> defined in the database. This is the data I was able to extract:</p>
  <ul>
    <li>
      Property usage with Direct Objects:
      <ul>
        @foreach($properties->usage->direct as $pid=>$tot)
            <li>{{ ucwords($properties->names[$pid]) }} =&gt; {{ $tot }}</li>
        @endforeach
      </ul>
    </li>
    <li>
      Property usage with Indirect Objects:
      <ul>
        @foreach($properties->usage->indirect as $pid=>$tot)
            <li>{{ ucwords($properties->names[$pid]) }} =&gt; {{ $tot }}</li>
        @endforeach
      </ul>
    </li>
    <li><a href="#">Click here</a> and dig more into details. <em>(Coming Soon)</em></li>
  </ul>
</div>
@stop