@extends('master')

@section('content')
    @auth
        @if($user->name == Auth::user()->name)
            test
        @endif
        @else
            no test
            @endauth
            <div class="ui card">
                <div class="content">
                    <div class="ui avatar">
                        <img src="/uploade/user/{{$user->image}}" class="bordered" style="width: 10em;height: 10em"> <span class="ui header">{{$user->name}}</span>
                    </div>
                </div>
                <div class="content center aligned">
                    <span class="meta">posts&nbsp;</span>{{$user->post->count()}} |
                    <span class="meta">comments&nbsp;</span>{{$user->comment->count()}}
                </div>
            </div>
            @if($posts->count())
                @foreach($posts as $post)

                    <div class="ui card">
                        <div class="content">
                            <div class="right floated meta">{{$post->created_at->toDayDateTimeString()}}</div>
                            <img class="ui avatar image"
                                 src="/uploade/user/{{$post->user->image}}">{{$post->user->name}}
                            &nbsp;<span
                                    class="meta">posted in</span>
                            <a
                                    href="{{url('/category/'.$post->category->name)}}">{{$post->category->name}}</a><span
                                    class="meta"> category</span>
                        </div>
                        <div class="content">
                            <h2><a href="{{url('/posts/'.$post->id)}}">{{$post->title}}</a></h2>
                            <p style="white-space: pre-wrap">{{$post->body}}&nbsp</p>
                            @if($post->url)

                                <div class="image">
                                    <img width="100%" src="/uploade/post/{{$post->url}}" alt=""
                                         style="padding: 5px; background: #e9e9e9">
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <h1 style="text-align: center; color: #999">There are no posts in the blog</h1>
            @endif
@endsection