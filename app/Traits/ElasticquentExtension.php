<?php

namespace App\Traits;

trait ElasticquentExtension
{
    /**
     * Elasticquent extension
     *
     * @return boolean
     */
    public static function indexExists()
    {
        $instance = new static;
        $client = $instance->getElasticSearchClient();
        $index = array(
            'index' => $instance->getIndexName(),
        );
        return $client->indices()->exists($index);
    }

    // need to update the index when we add, update or delete
}
