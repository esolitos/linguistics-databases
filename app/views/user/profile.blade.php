@extends("common.layout")
@section("content")
	<h2>Hello {{ Auth::user()->username }}</h2>
	<p>Welcome to your sparse profile page.</p>
	<ul>
		<li><a href="/user/logout">Log Out</a></li>
	</ul>
@stop