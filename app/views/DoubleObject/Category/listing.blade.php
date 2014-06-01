@extends("common.layout")
@section("content")
	<h3>Defined Categories</h3>
  <div class="listing">
    <table border="0" cellspacing="0" cellpadding="5">
      <thead>
        <tr>
          <th>First Object</th>
          <th>Second Object</th>
          <th colspan="3">Actions</th>
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
          <td>Occurrences [TODO]</td>
          <td class="actions edit">{{ link_to_action("CategoryController@edit", "Edit Category", [$cat->id]) }}</td>
          <td class="actions remove">{{ link_to_route("category.delete", "Remove Category", [$cat->id]) }}</td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>

@stop