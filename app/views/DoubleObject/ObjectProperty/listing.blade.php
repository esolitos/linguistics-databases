@extends("common.layout")
@section("content")
	<h3>Defined Object Properties</h3>
  <div class="listing">
    <table border="0" cellspacing="0" cellpadding="5">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th colspan="3">Actions</th>
        </tr>
      </thead>
      <tbody>
      @foreach(ObjectProperty::all() as $prop)
        <tr id="row-property-{{$prop->id}}">
          <td>{{ $prop->id }}</td>
          <td>{{ $prop->name }}</td>
          <td class="actions view">View Occurrences [TODO]</td>
          <td class="actions edit">{{ link_to_action("ObjectPropertyController@edit", "Edit", [$prop->id]) }}</td>
          <td class="actions remove">{{ link_to_route("objectProperty.delete", "Remove", [$prop->id]) }}</td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>

@stop