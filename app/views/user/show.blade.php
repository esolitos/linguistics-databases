@extends("common.layout")
@section("content")

<h3 class="subheader">{{ $user->username }} <em>({{ $user->id }})</em></h3>
  <div class="small-12 medium-4 large-2 columns">
    {{ Gravatar::image($user->email, $user->full_name) }}
    <br><small><a href="http://gravatar.com" alt="Gravatar Profile Image" target="_blank">Change image on Gravatar</a></small>
  </div>
  <div class="small-12 medium-8 large-10 columns">
    <ul class="no-bullet">
      <li>Name: <strong>{{ $user->full_name }}</strong></li>
      <li>eMail: <strong>{{ $user->email }}</strong></li>
      <li>Profession: <strong>{{ $user->profession }}</strong></li>
      <li>&nbsp;</li>
      <li>Registration: <em>{{ $user->created_at }}</em></li>
      <li>Last Update: <em>{{ $user->updated_at }}</em></li>
    </ul>
  </div>
  {{-- Do not allow editing anon and admin users --}}
  @if( $user->id > 1 )
  <div class="small-12 columns form-actions">
    {{ link_to_action('UserAdminController@index', '&larr; Back', [], ['class'=>"small button radius secondary"]) }}
    {{ link_to_action('UserAdminController@edit', 'Edit', $user->id, ['class'=>"small button  radius"]) }}
    {{ link_to_route('user.delete', 'Delete', $user->id, ['class'=>"small button radius alert"]) }}
  </div>
  @endif

@stop
