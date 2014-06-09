@extends("common.layout")
@section("content")

<h3>All Occurrences {{-- by Category --}}</h3>
@if( ! empty( $condition ) )
    <h5 class="subheader">Having <strong>{{$condition->filter}}</strong> equal to <code>{{$condition->value}}</code></h5>
@endif

<div id="occurrences-listing-page">

  <div id="filter-area" class="row">
    <div class="small-12 columns end">
      <p>In this area you can define filters based on the occurrences properties.</p>
    </div>
    @if( empty( $condition ) || !stristr('category', $condition->filter) )
    <div class="small-12 columns">
      <span>Categories: </span>
      <ul class="row categories">
        {{-- <li><label><input type="checkbox" name="categories" value=""> All Categories</label></li> --}}
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
          <th class="o-id">ID</th>
          <th class="o-category">Category</th>
          <th class="o-text">Text</th>
          <th class="o-verb">Verb</th>
          <th class="o-keyword">Keyword</th>
          <th class="o-corpus">Corpus</th>
          <th class="actions edit"></th>
          <th class="actions delete"></th>
        </tr>
      </thead>
      <tfoot>
        <th></th>
        <th>Category</th>
        <th>Text</th>
        <th>Verb</th>
        <th>Keyword</th>
        <th>Corpus</th>
        <th></th>
        <th></th>
      </tfoot>
      <tbody>
        @foreach($occurrences/*->where('category_id', '=', $cat_id)->get()*/ as $occ) 
        <tr{{-- data-occurrence="{{$occ->id}}" --}}>
          <td>{{  $occ->id }}</td>
          <td data-category="{{$occ->category_id}}">{{ $allCategories[$occ->category_id] }}</td>
          <td>{{ link_to_action('OccurrenceController@show', $occ->text, [$occ->id], ['class'=>"occurrence-text"]) }}</td>
          <td>{{ $occ->verb }}</td>
          <td>{{ $occ->keyword }}</td>
          <td>{{ $occ->corpus_file }}:{{ $occ->corpus_row }}</td>
          <td>{{ link_to_action('OccurrenceController@edit', "", [$occ->id], ['class'=>'fi-pencil actions edit', 'title'=>"Edit"]) }}</td>
          <td>{{ link_to_route('occurrence.delete', "", [$occ->id], ['class'=>'fi-trash actions delete', 'title'=>"Delete"]) }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div> <!-- /#occurrences-listing-page -->

<div class="hide scripts">
  {{-- <link rel="stylesheet" href="//cdn.datatables.net/1.10.0/css/jquery.dataTables.css" type="text/css" media="screen" charset="utf-8"> --}}
  <link rel="stylesheet" href="//cdn.datatables.net/plug-ins/be7019ee387/integration/foundation/dataTables.foundation.css" type="text/css" media="screen" charset="utf-8">
  <script src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js" type="text/javascript"></script>
  <script src="//cdn.datatables.net/plug-ins/be7019ee387/integration/foundation/dataTables.foundation.js" type="text/javascript"></script>
  <script type="text/javascript" src="/javascript/category.filter.js"></script>
</div>
@stop