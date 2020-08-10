<?php

namespace App\Api\Resources;

/**
 * @OA\Schema(
 *     title="EntriesResource",
 *     description="Entries resource",
 *     @OA\Xml(
 *         name="EntriesResource"
 *     )
 * )
 */

class EntriesResource
{
    /**
     * @OA\Property(
     *      title="href",
     *      description="Resource URL",
     *      example="https://arhitecture-catalogue.test/api/v1/entries"
     * )
     *
     * @var string
     */
    public $href;

    /**
     * @OA\Property(
     *     title="TimeStamp",
     *     description="TimeStamp",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @OA\Property(
     *     title="Entries",
     *     description="Architecture Catalogue entries",
     *
     * )
     *
     * @var \App\Api\Schemas\Entry[]
     */
    private $entries;
}
