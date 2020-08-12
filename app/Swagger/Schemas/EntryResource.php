<?php

namespace App\Swagger\Schemas;

/**
 * @OA\Schema(
 *     title="EntryResource",
 *     description="Entry resource",
 *     @OA\Xml(
 *         name="EntryResource"
 *     )
 * )
 */

class EntryResource
{
    /**
     * @OA\Property(
     *      title="href",
     *      description="Resource URL",
     *      example="https://arhitecture-catalogue.test/api/v1/entries/1"
     * )
     *
     * @var string
     */
    private $href;

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
     *     title="Entry",
     *     description="Architecture Catalogue Entry",
     *
     * )
     *
     * @var \App\Swagger\Schemas\Entry
     */
    private $entry;
}
