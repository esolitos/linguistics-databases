@extends("common.layout")
@section("content")

    <div class="listing users">
        <table class="defined-users" border="0" cellspacing="0" cellpadding="5">
            <thead>
            <tr>
                {{-- <th class="id">UID</th> --}}
                <th class="full-name">Name</th>
                <th class="username">Username</th>
                <th class="email">eMail</th>
                <th class="actions">&nbsp;</th>
                <th class="actions">&nbsp;</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr class="user-{{$user->id}} {{($user->id%2) ? 'odd' : 'even'}}">
                    {{-- <td>{{ $user->id }}</td> --}}
                    <td>{{ link_to_action('UserAdminController@show', $user->full_name, [$user->id], ['title'=>"View User"]) }} </td>
                    <td>{{ $user->username }} </td>
                    <td>{{ HTML::mailto($user->email, $user->email) }}</td>
                    <td>{{ link_to_action('UserAdminController@edit', '', [$user->id], ['class'=>'fi-pencil actions edit', 'title'=>"Edit User"]) }}</td>
                    <td>{{ link_to_route('user.delete', '', [$user->id], ['class'=>'fi-trash actions delete', 'title'=>"Delete User"]) }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

@stop