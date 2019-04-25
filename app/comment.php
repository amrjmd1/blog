<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\post;

class comment extends Model
{
    protected $fillable = [
        'body' , 'post_id' , 'user_id'
    ];

    public function posts()
    {
        return $this->belongsTo(post::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
