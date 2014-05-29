@extends("common.layout")
@section("content")
  
<h2>Double Object Database</h2>
<p>Database of duble object structures in Croatian</p>

<h3>Occurrences Categories</h3>
<ul class="list">
  @foreach(OccurrenceCategory::allForSelect() as $cid=>$category)
    <li><a href="#category-{{ $cid }}">{{ $category }}</a></li>
  @endforeach
</ul>

<h3>All Occurrences</h3>
<div class="listing">
  @foreach(OccurrenceCategory::allForSelect() as $cat_id => $category)
    <h4 id="category-{{ $cat_id }}">{{ $category }}</h4>
    @if( Occurrence::where('category_id', '=', $cat_id)->count() )
      <table border="0" cellspacing="0" cellpadding="5">
        <thead>
          <tr>
          <th>ID</th>
          <th>Text</th>
          <th>Verb</th>
          <th>Keyword</th>
          <th>Corpus Location</th>
          <th colspan="3">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach(Occurrence::where('category_id', '=', $cat_id)->get() as $occ)
        <tr>
          <td>{{ $occ->id }}</td>
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
    @else
      <p>E<em>mpty Category</em></p>
    @endif
  @endforeach 

  </div>

@stop