<?php

namespace App\Http\Controllers;

use App\Category;
use App\Notification;
use App\post;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use DB;
use App\comment;
use Illuminate\Support\Facades\Auth;


class PagesController extends Controller
{
    public function getNotifications()
    {
        if (Auth::check()) {
            $notifications = Notification::where('user_id', Auth::user()->id)->get();
            $users = array();
            foreach ($notifications as $user) {
                array_push($users, User::where('id', $user['Interactive_user'])->first());
            }
            return response()->json(array('isLogin' => true, 'notification' => $notifications, 'user' => $users));
        }
        return response()->json(array('isLogin' => false));
    }

    public function userPage($name)
    {
        $user = User::where('name', $name)->first();
        $posts = post::where('user_id', $user->id)->get();
        return view('content.profile', compact('name', 'user', 'posts'));
    }

    public function posts()
    {
        $posts = post::all()->reverse();
        return view('content.posts', compact('posts'));
    }

    public function post($post)
    {
        $posts = post::find($post);
        $comments = comment::where('post_id', $post)->get();
        if (Auth::check())
            Notification::where('post_id', $post)->where('user_id', Auth::user()->id)->delete();
        return view('content.post', compact('posts', 'comments'));
    }

    public function store(Request $request)
    {
        $this->validate(request(), [
            'title' => 'required|max:191',
            'body' => 'required|max:255',
            'url' => 'image'
        ]);

        if ($request->hasFile('url')) {
            $imageName = time() . '.' . $request->file('url')->getClientOriginalExtension();
            $request->file('url')->move(public_path('/uploade/post'), $imageName);
        } else {
            $imageName = '';
        }
        post::create([
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'category_id' => $request->input('category'),
            'user_id' => Auth::user()->id,
            'url' => $imageName,

        ]);
        return back();
    }

    public function category($name)
    {
        $catCur = Category::where('name', $name)->value('id');
        $posts = post::where('category_id', $catCur)->get();
        return view('content.category', compact('posts', 'name'));
    }

    public function admin()
    {
        $users = User::all();
        return view('admin', compact('users'));
    }

    public function addRole(Request $request)
    {

        $user = User::where('email', $request['email'])->first();
        $user->roles()->detach();

        if ($request['role_user']) {
            $user->roles()->attach(Role::where('name', 'user')->first());
        }

        if ($request['role_editor']) {
            $user->roles()->attach(Role::where('name', 'editor')->first());
        }
        if ($request['role_admin']) {
            $user->roles()->attach(Role::where('name', 'admin')->first());
        }

        return back();
    }

    public function editor()
    {
        return view('editor');
    }

    public function deletePost()
    {
        if (Auth::check()) {
            if (post::where('id', $_POST['post'])->where('user_id', Auth::user()->id)->delete())
                return response()->json(array('msg' => true));
            else
                return response()->json(array('msg' => false));
        }
        return response()->json(array('msg' => 'no login'));
    }
}
