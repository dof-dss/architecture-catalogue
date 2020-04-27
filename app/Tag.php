<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Traits\AuditsActivity;

class Tag extends Model
{
    use AuditsActivity;

    // mass assignable attributes
    protected $fillable = [
        'name'
    ];

    public function entries()
    {
        return $this->belongsToMany('App\Entry');
    }
}
