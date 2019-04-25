@extends('master')
@section('title'){{$posts->title}}@endsection
@section('script')
    <script src="/js/post.js"></script>
@endsection
@section('content')
    <div class="ui card">
        <div class="content">
            <div class="right floated meta">{{ date('D, M d, Y h:i A', strtotime($posts->created_at))}}</div>
            <a href="{{url('/profile/'.$posts->user->name)}}"><img class="ui avatar image"
                                                                   src="/uploade/user/{{$posts->user->image}}">{{$posts->user->name}}
            </a>&nbsp;<span
                    class="meta">posted in</span>
            <a href="{{url('/category/'.$posts->category->name)}}">{{$posts->category->name}}</a><span
                    class="meta"> category</span>
        </div>
        <div class="content">
            <h2>{{$posts->title}}</h2>
            <p style="white-space: pre-wrap">{{$posts->body}}&nbsp</p>
            @if($posts->url)

                <div class="image">
                    <img width="100%" src="/uploade/post/{{$posts->url}}" alt=""
                         style="padding: 5px; background: #e9e9e9">
                </div>
            @endif

        </div>
        <div class="extra content">
            @auth
                <span onclick="like()"><span class="likePost">{{$posts->likes->count()}}</span><i
                            class="like icon icpo @foreach($posts->likes as $l)@if($l->user_id == Auth::user()->id) red @endif @endforeach "></i></span>
                <input type="hidden" name="user" value="{{Auth::user()->id}}">
                <input type="hidden" name="post" value="{{$posts->id}}">
            @else
                <span>
                {{$posts->likes->count()}} <i class="like icon"></i>
            </span>
            @endauth
            <span>
                <span class="counter-comment">{{$comments->count()}}</span> <i class="comments icon"></i>
            </span>
            @if($comments->count())
                <div class="ui small comments">
                    @foreach($comments as $comment)
                        <div class="comment">
                            <a class="avatar" href="{{url('/profile/'.$comment->user->name)}}">
                                <img src="/uploade/user/{{$comment->user->image}}">
                            </a>
                            <div class="content">
                                <a class="author"
                                   href="{{url('/profile/'.$comment->user->name)}}">{{$comment->user->name}}</a>
                                <div class="metadata">
                                    <span class="date"> at&nbsp;{{$comment->created_at->toDayDateTimeString()}} </span>
                                </div>
                                <div class="text">
                                    {{$comment->body}}
                                    @auth
                                        @if(Auth::user()->id == $comment->user->id)
                                            <i class="trash icon" data-comment-delete="{{$comment->id}}"></i>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            @auth
                <div class="ui input myComment">
                    <input name="body" placeholder="Your Comment ..." required>
                </div>
            @endauth
        </div>
    </div>

@endsection