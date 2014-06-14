@extends("common.layout")
@section("content")
  
  {{ Form::open( array('route' => 'user.login') ) }}

  <div class="row">
    <div class="small-12 medium-6 large-4 columns">
      <label for='username' class="{{ $errors->has("username") ? 'error' : '';  }}">
        Username
        {{ Form::text("username", Input::old("username")) }}
        @if ( $errors->has("username"))
          <span class="error">{{ $errors->first("username") }}</span>
        @endif
      </label>
    </div>
    <div class="small-12 medium-6 large-4 columns">
      <label for="password" class="{{ $errors->has("password") ? 'error' : '';  }}">
        Password
        {{ Form::password("password") }}
        @if ( $errors->has("password"))
          <span class="error">{{ $errors->first("password") }}</span>
      	@endif
      </label>
    </div>
    <div class="small-12 medium-6 large-4 columns">
        {{ Form::submit("login", ['class'=>'small button']) }}
    </div>
    <p class="small-12 columns">
      To use this website it is required to have an access. Soon a read-only account 
      will be created and released (you'll find the credentials in this page) to
      review the data, for now if you need an access please contact us at our
      <a href="mailto:marta@velnic.net?subject=DoubleObjectDatabase">e-mail</a>.
    </p>
  </div>
  {{ Form::close() }}
@stop