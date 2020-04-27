<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Traits\AuditsActivity;

class EntryTag extends Model
{
    use AuditsActivity;
    
    // override table name being defaulted to plural
    protected $table = "entry_tag";

    // mass assignable attributes
    protected $fillable = [
        'entry_id',
        'tag_id'
    ];
}
