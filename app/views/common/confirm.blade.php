@extends("common.layout")
@section("content")
	<h3>{{ $confirm['title'] }}</h3>
  {{ Form::open( ['url' => $confirm['path'], 'method' => 'DELETE'] ) }}
  {{ Form::hidden('confirm', 1) }}
  {{-- {{ Form::form_checkbox('confirm', '1', "Check this Confirm Action") }} --}}

  <p>{{ $confirm['message'] }}</p>
  <div class="form-actions">
    <ul class="button-group radius">
      <li>{{ link_to( $confirm['cancel-url'], 'Cancel', ['class'=>'button small alert']) }}</li>
      <li>{{ Form::submit('Confirm Deletion', ['class'=>'button small secondary']) }}</li>  
    </ul>
  </div>

  {{ Form::close() }}

@stop