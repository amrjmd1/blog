<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'user_id' , 'type', 'post_id', 'Interactive_user'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
