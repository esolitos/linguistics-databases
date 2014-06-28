@extends("common.layout")
@section("content")


  @if( $create )
    {{ Form::open(array('action' => 'UserAdminController@store')) }}
  @else
    <h3 class="subheader">{{ $user->username }} <em>({{ $user->id }})</em></h3>

    {{ Form::open(array('action' => ['UserAdminController@update', $user->id], 'method' => 'PATCH')) }}
    <div class="small-12 medium-4 large-2 columns">
      {{ Gravatar::image($user->email, $user->full_name) }}
      <br><small><a href="http://gravatar.com" alt="Gravatar Profile Image" target="_blank">Change image on Gravatar</a></small>
    </div>
  @endif
    

  <div class="small-12 medium-8 large-10 columns">
    <div class="row">
      <div class="small-12 large-6 columns">
        {{ Form::withLabel('username')->text('username', $user->username) }}
      </div>
      <div class="small-12 large-6 columns">
        {{ Form::withLabel('email')->email('email', $user->email) }}
      </div>
    </div>
    <div class="row">
      <div class="small-12 large-6 columns">
        {{ Form::withLabel('full_name')->text('full_name', $user->full_name) }}
      </div>
      <div class="small-12 large-6 columns end">
        {{ Form::withLabel('profession')->text('profession', $user->profession) }}
      </div>
    </div>
    <div class="row">
      
      @if( $admin_edit )
        <div class="small-12 columns">
          {{-- {{ Form::withLabel('require_new_pwd', "Require password change on next login.")->checkbox('require_new_pwd', $user->profession) }} --}}
        </div>
        <div class="small-12 large-6 columns"><small>Registration Date: <em>{{ $user->created_at }}</em></small></div>
        <div class="small-12 large-6 columns"><small>Profile Last Updated: <em>{{ $user->updated_at }}</em></small></div>
      @else
        <div class="small-12 large-6 columns">
          {{ Form::withLabel('password')->password('password') }}
        </div>
        <div class="small-12 large-6 columns">
          {{ Form::withLabel('password_confirmation')->password('password_confirmation') }}
        </div>
      @endif
     </div> 
    </div>
    </ul>
  </div>
  <div class="form-actions">
    @if( $create )
      {{ link_to_action('UserAdminController@index', '&larr; Back to List', null, ['class'=>"small button secondary"]) }}
      {{ Form::submit('Carete User', ['class'=>'button small']) }}
    @else
      {{ link_to_action('UserAdminController@show', 'Cancel', $user->id, ['class'=>"small button secondary"]) }}
      {{ Form::submit('Save Changes', ['class'=>'button small']) }}
    @endif
  </div>
  {{ Form::close() }}
  

@stop
