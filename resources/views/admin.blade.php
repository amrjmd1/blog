@extends('master')
@section('content')
    <div>
        this bage for admin
        {{--<table class="ui selectable celled table center aligned">--}}
            {{--<tr class="active">--}}
                {{--<td>ID</td>--}}
                {{--<td>Name</td>--}}
                {{--<td>E-mail</td>--}}
                {{--<td>User</td>--}}
                {{--<td>Editor</td>--}}
                {{--<td>Admin</td>--}}
            {{--</tr>--}}
            {{--@foreach($users as $user)--}}
                {{--<form class="ui form" method="post" action="/add_role">--}}
                    {{--{{csrf_field()}}--}}
                    {{--<input type="hidden" name="email" value="{{$user->email}}">--}}
                    {{--<tr>--}}
                        {{--<td>{{$user->id}}</td>--}}
                        {{--<td>{{$user->name}}</td>--}}
                        {{--<td>{{$user->email}}</td>--}}
                        {{--<td>--}}
                            {{--<div class="ui toggle checkbox">--}}
                                {{--<input type="checkbox" name="role_user"--}}
                                       {{--onchange="this.form.submit()" {{$user->hasRole('User') ?  ' checked' : ''}}>--}}
                                {{--<label></label>--}}
                            {{--</div>--}}
                        {{--</td>--}}
                        {{--<td>--}}
                            {{--<div class="ui toggle checkbox">--}}
                                {{--<input type="checkbox" name="role_editor"--}}
                                       {{--onchange="this.form.submit()" {{$user->hasRole('Editor') ?  ' checked' : ''}}><label></label>--}}
                            {{--</div>--}}
                        {{--</td>--}}
                        {{--<td>--}}
                            {{--<div class="ui toggle checkbox">--}}
                                {{--<input type="checkbox" name="role_admin"--}}
                                       {{--onchange="this.form.submit()" {{$user->hasRole('Admin') ?  ' checked' : ''}}><label></label>--}}
                            {{--</div>--}}
                        {{--</td>--}}
                    {{--</tr>--}}
                {{--</form>--}}
            {{--@endforeach--}}
        {{--</table>--}}
    </div>
@endsection