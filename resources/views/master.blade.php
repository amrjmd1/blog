<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="something" content="{{ csrf_token() }}"/>

    <title>@yield('title')</title>

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="/css/semantic.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.1.8/components/icon.min.css">
    <!-- Custom CSS -->
    <link href="/css/blog-home.css" rel="stylesheet">
</head>

<body>


<!-- Page Content -->
<div class="ui middle aligned stackable grid container">
    <nav class="ui  pointing menu fixed">
        <a class="item" href="{{route('home')}}">
            <i class="home icon"></i> Home
        </a>

        <div class="mySe">
            <div class="ui category search">
                <div class="ui search">
                    <input class="prompt" name="Search" placeholder="Search users..." type="text"
                           onkeyup="resulteSearch(value)">
                    <div class="results transition  re"></div>
                </div>
            </div>
        </div>
        @if(Auth::check())
            <div class="notifications">

                {{--<ul class="showNotifications">--}}

                {{--</ul>--}}
                <div class="ui inline dropdown">
                    <i class="bell icon"><span class="counter"></span></i>
                    <div class="menu"></div>
                </div>
            </div>
        @endif
    </nav>

    <div class="row">
        <div class="ten wide column">
            @yield('content')
        </div>
        <div class="six wide right floated column">

            <div class="ui card">
                <div class="ui content center aligned">
                    @auth()
                        <img src="/uploade/user/{{Auth::user()->image}}" class="ui avatar image bordered"
                             style="width: 5em; height: 5em">
                        <h3><a href="{{url('/profile/'.Auth::user()->name)}}">{{Auth::user()->name}}</a></h3>
                        <h4>you have <span id="countPostInMaster">{{Auth::user()->post->count()}}</span> post & {{Auth::user()->comment->count()}}
                            comment</h4>
                        <a href="{{Route('logout')}}" class="ui inverted blue button">Logout</a>
                        @if(auth::user()->hasRole('Admin'))
                            <a href="{{Route('adminRoute')}}" class="ui inverted blue button">Admin</a>
                        @endif
                    @else
                        <h3 class="">blog </h3>
                        <div class="ui buttons">
                            <a href="{{ route('login') }}" class="ui  green button">&nbsp;LogIn</a>
                            <div class="or"></div>
                            <a href="{{ route('register') }}" class="ui  blue button">SignUp</a>
                        </div>
                    @endauth
                </div>
            </div>


            <div class="ui card">
                <div class="content">
                    <h4>Blog Categories</h4>
                    @foreach($categorys as $cat)
                        <div class="ui middle aligned animated list">
                            <div class="item">
                                <div class="content">
                                    <div class="header"><a href="{{url('/category/'.$cat->name)}}">{{$cat->name}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>


    </div>
</div>
<!-- /.container -->


<script src="/js/jq.js"></script>
<script src="/js/semantic.min.js"></script>
<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>-->
<script src="/js/myjs.js"></script>
@yield('script')
</body>

</html>