<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    // mass assignable attributes
    protected $fillable = [
        'name',
        'version',
        'description',
        'href',
        'sub_category',
        'category',
        'status',
        'functionality',
        'service_levels',
        'interfaces',
        'related_sbbs'
    ];
}
