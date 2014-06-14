@extends("DoubleObject.layout")
@section("content")
  
  <h3 class="subheader">Defined Properties</h3>
  <div class="listing">
    <table class="defined-object-properties" border="0" cellspacing="0" cellpadding="5">
      <thead>
        <tr>
          <th class="id">ID</th>
          <th>Name</th>
          <th class="actions">&nbsp;</th>
          <th class="actions">&nbsp;</th>
        </tr>
      </thead>
      <tbody>
      @foreach(ObjectProperty::all() as $prop)
        <tr id="row-property-{{$prop->id}}">
          <td>{{ $prop->id }}</td>
          <td>{{ ucwords($prop->name) }}</td>
          <td>{{ link_to_action("ObjectPropertyController@edit", '', [$prop->id], ['class'=>'fi-pencil actions edit', 'title'=>"Edit"]) }}</td>
          <td class="actions remove">{{ link_to_route("objectProperty.delete", '', [$prop->id], ['class'=>'fi-trash actions delete', 'title'=>"Delete"]) }}</td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>

@stop