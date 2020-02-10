<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Elasticquent\ElasticquentTrait;
use App\Traits\ElasticquentExtension;

class Entry extends Model
{
    use ElasticquentTrait;
    use ElasticquentExtension;

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

    public function tags()
    {
        return $this->belongsToMany('App\Tag');
    }


}
