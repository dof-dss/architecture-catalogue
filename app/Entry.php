<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Elasticquent\ElasticquentTrait;
use App\Traits\ElasticquentExtension;
// use Spatie\Activitylog\Traits\LogsActivity;
use App\Traits\AuditsActivity;

class Entry extends Model
{
    use ElasticquentTrait;
    use ElasticquentExtension;
    use AuditsActivity;

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
    ];

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    // model events to be recorded by AuditsActivity
    protected static $recordEvents = [
        'created',
        'updated',
        'deleted',
    ];

    // elasticquent mappings
    protected $mappingProperties = array (
        'name' => [
            'type' => 'text',
            'analyzer' => 'standard'
        ],
        'description' => [
            'type' => 'text',
            'analyzer' => 'standard'
        ],
        'category' => [
            'type' => 'text',
            'analyzer' => 'standard'
        ],
        'sub_category' => [
            'type' => 'text',
            'analyzer' => 'standard'
        ],
        'functionality' => [
            'type' => 'text',
            'analyzer' => 'standard'
        ],
        'service_levels' => [
            'type' => 'text',
            'analyzer' => 'standard'
        ],
        'interfaces' => [
            'type' => 'text',
            'analyzer' => 'standard'
        ],
    );

    public function children()
    {
        return $this->hasMany('App\Link', 'item1_id');
    }

    public function parents()
    {
        return $this->hasMany('App\Link', 'item2_id');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }
}
