<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntryTag extends Model
{
    // override table name being defaulted to plural
    protected $table = "entry_tag";

    // mass assignable attributes
    protected $fillable = [
        'entry_id',
        'tag_id'
    ];
}
