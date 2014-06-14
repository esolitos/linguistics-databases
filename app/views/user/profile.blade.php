@extends("common.layout")
@section("content")

  <h3>Welcome back <em>{{ ucwords(Auth::user()->username) }}</em><br><small class="subheader">e-mail: {{ Auth::user()->email }}</small></h3>
  <p>
    Welcome to your sparse profile page. For now there's nothing to show you in
    this page, soon, one day maybe you'll find something. Keep looking!
  </p>

@stop