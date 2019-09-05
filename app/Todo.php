<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    
    protected $fillable = [
        "user_id", "title", "confirmed"
    ];
    public function user(){
        $this->belongsTo('App\User');
    }

}
