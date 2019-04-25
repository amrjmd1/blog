<?php

namespace App\Http\Controllers;

use App\like;
use App\Notification;
use App\post;
use App\Comment;
use App\User;
use foo\bar;
use Illuminate\Support\Facades\Auth;


class CommentsController extends Controller
{
    public function store()
    {
        $body = $_POST['body'];
        if ($body != null) {
            if (strlen($body) <= 140) {
                $post_id = intval($_POST['post_id']);
                $user_post_id = post::select('user_id')->where('id', $post_id)->first()['user_id'];
                if ($user_post_id != Auth::user()->id) {
                    Notification::create([
                        'user_id' => $user_post_id,
                        'type' => 1,
                        'post_id' => $post_id,
                        'Interactive_user' => Auth::user()->id
                    ]);
                }
                $comment = new Comment();
                $comment->user_id = Auth::user()->id;
                $comment->post_id = $post_id;
                $comment->body = $body;
                if ($comment->save())
                    $res = array('msg' => 'Done', 'comment' => $comment);
                else
                    $res = array('msg' => 'Null');
                return response()->json($res);
            } else
                return response()->json(array('msg' => "long"));
        }
        return response()->json(array('msg' => "empty"));
    }

    public function delete()
    {
        if (Auth::check()) {
            $comment = $_POST['comment'];
            if (Comment::where('user_id', Auth::user()->id)->where('id', $comment)->delete())
                return response()->json(array('msg' => 'Done'));
            return response()->json(array('msg' => 'Null'));
        }
        return response()->json(array('msg' => 'no login'));
    }

    public function like()
    {
        $user = $_POST['user'];
        if (Auth::check()) {
            if (Auth::user()->id == $user) {
                $post = $_POST['post_id'];
                $like = like::select('status')->where('post_id', $post)->where('user_id', $user)->first();

                if ($like == null) {
                    $user_post_id = post::select('user_id')->where('id', $post)->first()['user_id'];
                    if ($user_post_id != Auth::user()->id) {
                        Notification::create([
                            'user_id' => $user_post_id,
                            'type' => 2,
                            'post_id' => $post,
                            'Interactive_user' => Auth::user()->id
                        ]);
                    }
                    like::create([
                        'status' => true,
                        'post_id' => $post,
                        'user_id' => $user,
                    ]);
                    $stat = true;
                } else {
                    $likeEdit = like::where('post_id', $post)->where('user_id', $user)->first();
                    $likeEdit->delete();
                    $stat = false;
                }
                return response()->json(array('msg' => $stat));
            }
            return response()->json(array('msg' => 'attack'));
        }
        return response()->json(array('msg' => 'no login'));
    }
}
