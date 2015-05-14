@extends("DoubleObject.layout")
@section("content")

  <div class="small-12 columns">
    <h3 class="subheader">Static Queries</h3>
    <p>Those queryes are fixed and it is only possible to change some small parameters, keep in mind that the results are updated only once every 6 hours.</p>

    <table style="width:100%" border="0" cellspacing="0" cellpadding="5">
      <thead>
        <tr><th>Type</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <tr>
          <td>Object Type/Position<br><small>short decription</small></td>
          <td>{{ link_to_action('QueryController@anyStatic', 'Run', ['objects-position'], ['class'=>'tiny button radius']) }}</td>
        </tr>
        <tr>
          <td>Related Properties<br><small>short decription</small></td>
          <td>{{ link_to_action('QueryController@anyStatic', 'Run', ['related-properties'], ['class'=>'tiny button radius']) }}</td>
        </tr>
        <tr>
          <td>Same Properties<br><small>short decription</small></td>
          <td>{{ link_to_action('QueryController@anyStatic', 'Run', ['same-property'], ['class'=>'tiny button radius']) }}</td>
        </tr>
      </tbody>
    </table>
    {{-- <h3 class="subheader">Dynamic Queries</h3>
    <p>
    <ul class="button-group">
      <li>{{ link_to_action('QueryController@getBuild', 'New Dynamic Query', [], ['class'=>'button']) }}</li>
    </ul> --}}
  </div>
  
  <div class="small-12 columns">
    <h5 class="subheader">Fun Fact</h5>
    <p>Up until today I have compiled and executed <strong>{{ $executed_queries }} queries!</strong></p>
  </div>
@stop