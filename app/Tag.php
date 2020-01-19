<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    // mass assignable attributes
    protected $fillable = [
        'name'
    ];

    public function entries()
    {
        return $this->belongsToMany('App\Entry');
    }
}
