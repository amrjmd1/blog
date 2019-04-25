<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Egulias\EmailValidator\Warning\Comment;


class post extends Model
{
    protected $fillable = [
        'title', 'body', 'url', 'category_id', 'user_id'
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('created_at');
    }

    public function likes()
    {
        return $this->hasMany(like::class)->orderBy('created_at');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
