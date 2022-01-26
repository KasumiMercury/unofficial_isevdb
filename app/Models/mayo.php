<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mayo extends Model
{
    use HasFactory;
    protected $table = 'players';

    public function Member()
        {
        return $this->belongsTo('App\Models\Member');
        }
}
