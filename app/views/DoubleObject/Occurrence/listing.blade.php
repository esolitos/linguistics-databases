@extends("common.layout")
@section("content")

<h3>All Occurrences by Category</h3>
<dl class="accordion occurrence-listing" data-accordion="myAccordionGroup">
  @foreach(OccurrenceCategory::allForSelect() as $cat_id => $category)
  <dd>
    <a href="#category-{{ $cat_id }}"><strong>({{ Occurrence::where('category_id', '=', $cat_id)->count() }})</strong> {{ $category }}</a>
    <div id="category-{{ $cat_id }}" class="content">
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
        <p class="empty"><em>Empty Category</em></p>
      @endif
      </div>
    @endforeach
  </dd>
  
</dl>

@stop