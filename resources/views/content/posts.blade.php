@extends('master')
@section('title')Home @endsection

@section('content')
    @auth
        <div class="ui basic mini modal deleteMsg">
            <div class="ui icon header">
                <i class="trash icon"></i>
                Are you sure you want to delete your post
            </div>
            <div class="actions">
                <div class="ui approve button">Approve</div>
                <div class="ui cancel button">Cancel</div>
            </div>
        </div>
        <div class="ui message transition hidden">
            <i class="close icon"></i>
            <p class="contentMessage"></p>
        </div>
        @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('editor'))
            <div class="ui styled accordion">
                <div class="title">
                    <i class="dropdown icon"></i>
                    Add new post !
                </div>
                <div class="content">
                    <form class="ui form" method="post" action="/posts/store" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="text" name="title" placeholder="Title ..." required>

                        <textarea name="body" placeholder="Body For Your Post ..."
                                  required></textarea>

                        <select name="category" class="ui dropdown" required>
                            @foreach($categorys as $c)
                                <option class="item" value="{{$c->id}}">{{$c->name}}</option>
                            @endforeach
                        </select>
                        <span class="ui button" style="position: relative; overflow: hidden;display: inline"><i
                                    class="file image outline icon"></i>

                            <input type="file" name="url"
                                   style="position: absolute;top: 0;right: 0;min-width: 100%;min-height: 100%;cursor:pointer; overflow: hidden;opacity: 0 ">
                         </span>
                        <input type="submit" class="ui button" value="Add post">
                        <span class="counter-post"><span>0</span> : 255</span>
                    </form>
                </div>
            </div>

        @endif  @endauth
    <!-- Third Blog Post -->

    @if($posts->count())
        @foreach($posts as $post)
            <div class="ui card myPost">
                <div class="content">
                    <div class="right floated meta">{{$post->created_at->toDayDateTimeString()}}</div>
                    <img class="ui avatar image" src="/uploade/user/{{$post->user->image}}"><a
                            href="{{url('/profile/'.$post->user->name)}}">{{$post->user->name}}</a>
                    &nbsp;<span
                            class="meta">posted in</span>
                    <a
                            href="{{route('category' , ['name'=>$post->category->name])}}">{{$post->category->name}}</a><span
                            class="meta"> category</span>
                </div>
                <div class="content">
                    <h2><a href="{{route('post' , ['post'=>$post->id])}}">{{$post->title}}</a></h2>
                    <p style="white-space: pre-wrap; word-break: break-word">{{$post->body}}&nbsp</p>
                    @if($post->url)
                        <div class="image">
                            <img width="300" src="/uploade/post/{{$post->url}}" alt=""
                                 style="padding: 5px; background: #e9e9e9">
                        </div>
                    @endif
                </div>
                <div class="ui dropdown active visible contextmenu">
                    <div class=" menu">
                        <ul>
                            <li><a href="{{route('post' , ['post'=>$post->id])}}"><i class="share icon"></i> open</a>
                            <li><a href="{{route('category' , ['name'=>$post->category->name])}}"><i
                                            class="linkify icon"></i> category</a>
                            </li>
                            @auth
                                @if(Auth::user()->id == $post->user->id)
                                    <li><i class="edit icon"></i> edit</li>
                                    <li class="deletePost" data-postnumper="{{$post->id}}"><i class="trash icon"></i>
                                        delete
                                    </li>
                                @endif
                            @endauth
                            <li class="separate"></li>
                            <li class="copyTitle" data-title="{{$post->title}}"><i class="copy icon"></i> copy title
                            </li>
                            <li class="copyContent" data-content="{{$post->body}}"><i class="copy icon"></i> copy
                                content
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <h1 style="text-align: center; color: #999">There are no posts in the blog</h1>
    @endif

@endsection