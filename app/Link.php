<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Traits\AuditsActivity;

class Link extends Model
{
    use AuditsActivity;
    
    // mass assignable attributes
    protected $fillable = [
        'item1_id',
        'item2_id',
        'relationship'
    ];

    public function parent()
    {
        return $this->belongsTo('App\Entry', 'item2_id', 'id');
    }

    public function child()
    {
        return $this->belongsTo('App\Entry', 'item1_id', 'id');
    }
}
