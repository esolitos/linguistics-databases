@extends("DoubleObject.layout")
@section("content")

  <h3 class="subheader">Defined Categories</h3>
  <div class="listing">
    <table class="defined-categories" border="0" cellspacing="0" cellpadding="5">
      <thead>
        <tr>
          <th>First Object</th>
          <th>Second Object</th>
          <th>Creator</th>
          <th class="actions">&nbsp;</th>
          <th class="actions">&nbsp;</th>
          <th class="actions">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
      @foreach(OccurrenceCategory::with('firstObj', 'secondObj')->get() as $cat)
        <?php $obj1 = $cat->firstObj ?>
        <tr class="category-{{$cat->id}} {{($cat->id%2) ? 'odd' : 'even'}}">
          <td><strong>{{$obj1->type}}</strong> <em>{{$obj1->form}} {{$obj1->declination}}</em> <small>{{($obj1->has_preposition) ? '+Prep.' : ''}}</small></td>
          @if( $cat->secondObj )
            <?php $obj2 = $cat->secondObj ?>
            <td><strong>{{$obj2->type}}</strong> <em>{{$obj2->form}} {{$obj2->declination}}</em> <small>{{($obj2->has_preposition) ? '+Prep.' : ''}}</small></td>
          @else
            <td>-</td>
          @endif
          <td>{{ $cat->author->username }}</td>
          <td>{{ link_to_route('category.occurrences', '', [$cat->id], ['class'=>'fi-list-bullet actions view-occurrences', 'title'=>"View Occurrences"]) }} </td>
          <td>{{ link_to_action("CategoryController@edit", '', [$cat->id], ['class'=>'fi-pencil actions edit', 'title'=>"Edit"]) }}</td>
          <td>{{ link_to_route("category.delete", '', [$cat->id], ['class'=>'fi-trash actions delete', 'title'=>"Delete"]) }}</td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>

@stop