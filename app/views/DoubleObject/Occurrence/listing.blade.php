@extends("DoubleObject.layout")
@section("content")

<h3>All Occurrences {{-- by Category --}}</h3>
@if( ! empty( $condition ) )
    <h5 class="subheader">I found {{ count($occurrences) }} Occurrences having <strong>{{$condition->filter}}</strong> equal to <code>{{$condition->value}}</code></h5>
@endif

@if( count($occurrences) <= 0 )
  <div class="row">
    <p class="small-12 columns end">No occurrence available for the given filters.</p>
    <div class="small-12 columns end">
      {{ link_to_action('OccurrenceController@index', 'View All Occurrences', null, ['class'=>"small button radius"]) }}
    </div>
  </div>
@else
  
<div id="occurrences-listing-page">
    <div id="filter-area" class="row">
      <div class="small-12 columns end">
        <p>In this area you can define filters based on the occurrences properties.</p>
      </div>
      @if( empty( $condition ) || !stristr('speaker', $condition->filter) )
      <div class="small-12 columns">
        <strong>Speaker: </strong>
        <ul class="row speakers">
          <li><label><input type="radio" name="speaker" value="">All</label></li>
          <li><label><input type="radio" name="speaker" value="A">Adults Only</label></li>
          <li><label><input type="radio" name="speaker" value="C">Children Only</label></li>
        </ul>
      </div>
      @endif
      @if( empty( $condition ) || !stristr('category', $condition->filter) )
      <div class="small-12 columns">
        <strong>Categories: </strong>
        <ul class="row categories">
          <li><label><input class="exclusive" type="checkbox" name="categories" value="DIR"> Has <strong>DIRect</strong> Object</label></li>
          <li><label><input class="exclusive" type="checkbox" name="categories" value="IND"> Has <strong>INDirect</strong> Object</label></li>
          <li><label><input class="exclusive no-escape" type="checkbox" name="categories" value="^DIR"> First is <strong>DIRect</strong> Object</label></li>
          <li><label><input class="exclusive no-escape" type="checkbox" name="categories" value="^IND"> First is <strong>INDirect</strong> Object</label></li>
        </ul>
      </div>
      @endif
    
    </div>
  
    <div class="row listing-content">
      <table id="occurrences-listing" class="display occurrences-listing">
        <thead>
          <tr>
            <th class="id">ID</th>
            <th class="o-category">Category</th>
            <th class="o-text">Text</th>
            <th class="o-verb">Verb</th>
            <th class="o-speaker">Speaker</th>
            <th class="o-keyword">Keyword</th>
            <th class="o-corpus">Corpus</th>
            <th class="author">By</th>
            <th class="actions edit"></th>
            <th class="actions delete"></th>
          </tr>
        </thead>
        <tfoot>
          <th></th>
          <th>Category</th>
          <th>Text</th>
          <th>Verb</th>
          <th>Speaker</th>
          <th>Keyword</th>
          <th>Corpus</th>
          <th><small>Inserted By User</small></th>
          <th></th>
          <th></th>
        </tfoot>
        <tbody>
          @foreach($occurrences as $occ) 
          <tr{{-- data-occurrence="{{$occ->id}}" --}}>
            <td>{{  $occ->id }}</td>
            <td data-category="{{$occ->category_id}}">{{ $allCategories[$occ->category_id] }}</td>
            <td>{{ link_to_action('OccurrenceController@show', $occ->text, [$occ->id], ['class'=>"occurrence-text"]) }}</td>
            <td>{{ $occ->verb }}</td>
            <td>{{ Occurrence::validSpeakers()[$occ->speaker] }}</td>
            <td>{{ $occ->keyword }}</td>
            <td>{{ $occ->corpus_file }}:{{ $occ->corpus_row }}</td>
            <td>{{ $occ->author->username }}</td>
            <td>{{ link_to_action('OccurrenceController@edit', "", [$occ->id], ['class'=>'fi-pencil actions edit', 'title'=>"Edit"]) }}</td>
            <td>{{ link_to_route('occurrence.delete', "", [$occ->id], ['class'=>'fi-trash actions delete', 'title'=>"Delete"]) }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>  <!-- /#occurrences-listing-page -->
@endif

@stop