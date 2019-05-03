<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Player extends Model{
	use SoftDeletes;
	
    protected $table = 'players';
	
    public function club()
    {
        return $this->belongsTo('App\Club');
    }
}
