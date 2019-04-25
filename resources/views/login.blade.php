@extends('master')
@section('content')


        <form method="post" action="/login" class="ui form">
            {{csrf_field()}}
            <input type="email" name="email" value="{{old('email')}}" class="ui required"
                   placeholder="Enter your E-mail" required>
            <input type="password" name="password" class=""
                   placeholder="Enter your password" required>
            <button type="submit" class="ui button">Login</button>
        </form>
        @foreach($errors->all() as $error)
            <div class="">{{$error}}</div>
        @endforeach


@endsection