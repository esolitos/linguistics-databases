@extends("DoubleObject.layout")
@section("content")

  <h3 class="subheader">Defined Categories</h3>
  <div class="listing">
    <table class="defined-categories" border="0" cellspacing="0" cellpadding="5">
      <thead>
        <tr>
          <th>1<sup>st</sup> Object</th>
          <th>2<sup>nd</sup> Object</th>
          <th>User</th>
          @if($can->viewOccurrences)
            <th class="actions"><abbr title="View Occurrences">List</span></th>
          @endif
          @if( $can->edit )
            <th class="actions">Edit</th>
          @endif
          @if( $can->delete )
            <th class="actions">Delete</th>
          @endif
        </tr>
      </thead>
      <tbody>
      @foreach(OccurrenceCategory::with('firstObj', 'secondObj')->get() as $cat)
        <tr class="category-{{$cat->id}} {{($cat->id%2) ? 'odd' : 'even'}}">
          <td>
            <strong>{{$cat->firstObj->type}}</strong>
            <em>{{$cat->firstObj->form}} {{$cat->firstObj->declination}}</em>
            @if($cat->firstObj->has_preposition)
              <small>+Prep.</small>
            @endif
          </td>
          <td>
            @if( $cat->secondObj )
              <strong>{{$cat->secondObj->type}}</strong>&nbsp;
              <em>{{$cat->secondObj->form}} {{$cat->secondObj->declination}}</em>&nbsp;
              @if($cat->secondObj->has_preposition)
                <small>+Prep.</small>
              @endif
            @else
              &dash;
            @endif
          </td>
          <td>{{ $cat->author->username }}</td>
          @if($can->viewOccurrences)
            <td>{{ link_to_route('category.occurrences', '', [$cat->id], ['class'=>'fi-list-bullet actions view-occurrences', 'title'=>"View Occurrences"]) }}</td>
          @endif
          @if( $can->edit )
            <td>{{ link_to_action("CategoryController@edit", '', [$cat->id], ['class'=>'fi-pencil actions edit', 'title'=>"Edit"]) }}</td>
          @endif
          @if( $can->delete )
            <td>{{ link_to_route("category.delete", '', [$cat->id], ['class'=>'fi-trash actions delete', 'title'=>"Delete"]) }}</td>
          @endif
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>

@stop