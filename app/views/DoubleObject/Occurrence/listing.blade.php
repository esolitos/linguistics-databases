@extends("common.layout")
@section("content")

<h3>All Occurrences {{-- by Category --}}</h3>
@if( ! empty( $condition ) )
    <h5 class="subheader">Having <strong>{{$condition->filter}}</strong> equal to <code>{{$condition->value}}</code></h5>
@endif
{{-- <dl class="accordion occurrence-listing" data-accordion="myAccordionGroup"> --}}
  {{-- @foreach($allCategories as $cat_id => $category) --}}
  {{-- @if( $occurrences->where('category_id', '=', $cat_id)->count() ) --}}
  
  {{-- <dd> --}}
    {{-- <a href="#category-{{ $cat_id }}"><strong>({{ $occurrences->where('category_id', '=', $cat_id)->count() }})</strong> {{ $category }}</a> --}}
    <div {{-- id="category-{{ $cat_id }}" --}} class="content">
      <table id="something" class="display occurrences-listing">
        <thead>
          <tr>
            <th>ID</th>
            <th>Category</th>
            <th>Text</th>
            <th>Verb</th>
            <th>Keyword</th>
            <th>Corpus Location</th>
            <th></th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach($occurrences/*->where('category_id', '=', $cat_id)->get()*/ as $occ) 
          <tr{{-- data-occurrence="{{$occ->id}}" --}}>
            <td>{{ $occ->id }}</td>
            <td data-category="{{$occ->category_id}}">{{ $allCategories[$occ->category_id] }}</td>
            <td>{{ $occ->text }}</td>
            <td>{{ $occ->verb }}</td>
            <td>{{ $occ->keyword }}</td>
            <td>{{ $occ->corpus_file }}:{{ $occ->corpus_row }}</td>
            <td class="actions view">{{ link_to_action('OccurrenceController@show', "View", [$occ->id]) }}</td>
            <td class="actions edit">{{ link_to_action('OccurrenceController@edit', "Edit", [$occ->id]) }}</td>
            <td class="actions delete">{{ link_to_route('occurrence.delete', "Delete", [$occ->id]) }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
      </div>
  {{-- </dd> --}}
  {{-- @endif --}}
  {{-- @endforeach --}}
{{-- </dl> --}}

{{-- <link rel="stylesheet" href="//cdn.datatables.net/1.10.0/css/jquery.dataTables.css" type="text/css" media="screen" charset="utf-8"> --}}
<link rel="stylesheet" href="//cdn.datatables.net/plug-ins/be7019ee387/integration/foundation/dataTables.foundation.css" type="text/css" media="screen" charset="utf-8">
<script src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js" type="text/javascript"></script>
<script src="//cdn.datatables.net/plug-ins/be7019ee387/integration/foundation/dataTables.foundation.js" type="text/javascript"></script>
<script type="text/javascript">
$().ready( function () {
  var table = $('table.occurrences-listing').DataTable({
    "columnDefs": [ { "targets": [-3, -2, -1], "searchable": false, "orderable": false } ]
  });  
} );
</script>
@stop