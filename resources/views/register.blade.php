@extends('master')
@section('content')
    <form method="post" action="/register" class="ui form">
        {{csrf_field()}}


        <input type="text" name="name" value="{{old('name')}}" class=""
               placeholder="Enter your name" required>

        <input type="email" name="email" value="{{old('email')}}" class=""
               placeholder="Enter your E-mail" required>

        <input type="password" name="password" class=""
               placeholder="Enter your password" required>

        <button type="submit" class="ui button">register</button>

    </form>
    @foreach($errors->all() as $e)
        <div class="ui message transition red">
            <i class="close icon"></i>
            <div class="header">
                {{$e}}
            </div>
        </div>
    @endforeach
@endsection