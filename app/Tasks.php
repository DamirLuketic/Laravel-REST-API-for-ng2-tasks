<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'start_date',
        'end_date',
        'description',
        'status'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }
}
