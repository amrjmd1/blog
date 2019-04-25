<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class like extends Model
{
    protected $fillable = [
        'status' , 'post_id' , 'user_id'
    ];
    public function posts()
    {
        return $this->belongsTo(post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
