@extends("common.layout")
@section("content")
  {{ Form::open() }}

  @if ( $errors->has("username"))
		<b>{{ $errors->first("username") }}</b>
	@endif
	{{ Form::label("username", "Username") }}
  {{ Form::text("username", Input::old("username")) }}
	
  @if ( $errors->has("username"))
    <b>{{ $errors->first("password") }}</b>
	@endif
  {{ Form::label("password", "Password") }}
  {{ Form::password("password") }}
	
  {{ Form::submit("login") }}
  {{ Form::close() }}
@stop