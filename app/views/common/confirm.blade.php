@extends("common.layout")
@section("content")

  <h3 class="subheader">{{ $confirm['title'] }}</h3>
  {{ Form::open( ['url' => $confirm['path'], 'method' => 'DELETE'] ) }}
  {{ Form::hidden('confirm', 1) }}
  {{-- {{ Form::form_checkbox('confirm', '1', "Check this Confirm Action") }} --}}

  @if( !empty($confirm['message']) )
    <p>{{ $confirm['message'] }}</p>    
  @endif

  <div class="form-actions">
      {{ link_to( $confirm['cancel-url'], 'Cancel', ['class'=>'small button secondary']) }}
      {{ Form::submit('Confirm Deletion', ['class'=>'small button alert']) }}
  </div>

  {{ Form::close() }}

@stop