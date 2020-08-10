<?php

namespace App\Api\Schemas;

/**
 * @OA\Schema(
 *     title="Entry",
 *     description="Entry model",
 *     @OA\Xml(
 *         name="Entry"
 *     )
 * )
 */

class Entry
{
    /**
     * @OA\Property(
     *     title="id",
     *     description="Unique identifier",
     *     format="int64",
     *     example=1
     * )
     *
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     *      title="href",
     *      description="Product page URL",
     *      example="https://php.net"
     * )
     *
     * @var string
     */
    public $href;

    /**
     * @OA\Property(
     *      title="Name",
     *      description="Name of the catalogue entry",
     *      example="PHP"
     * )
     *
     * @var string
     */
    public $name;

    /**
     * @OA\Property(
     *      title="Version",
     *      description="Version of the catalogue entry",
     *      example="7.3.13"
     * )
     *
     * @var string
     */
    public $version;

    /**
     * @OA\Property(
     *      title="Description",
     *      description="Description of the catalogue entry",
     *      example="PHP is a popular general-purpose scripting language that is especially suited to web development"
     * )
     *
     * @var string
     */
    public $description;

    /**
     * @OA\Property(
     *      title="Category",
     *      description="Catalogue entry category",
     *      example="Infrastructure Applications"
     * )
     *
     * @var string
     */
    public $category;

    /**
     * @OA\Property(
     *      title="Sub-category",
     *      description="Catalogue entry sub-category",
     *      example="Development Tools"
     * )
     *
     * @var string
     */
    public $sub_category;

    /**
     * @OA\Property(
     *      title="Status",
     *      description="Catalogue entry status",
     *      example="Approved"
     * )
     *
     * @var string
     */
    public $status;

    /**
     * @OA\Property(
     *      title="Functionality",
     *      description="Catalogue entry functionality",
     *      example="See https://www.php.net/docs.php"
     * )
     *
     * @var string
     */
    public $functionality;

    /**
     * @OA\Property(
     *      title="Service levels",
     *      description="Catalogue entry service levels",
     *      example="n/a"
     * )
     *
     * @var string
     */
    public $service_levels;

    /**
     * @OA\Property(
     *      title="Interfaces",
     *      description="Catalogue entry interfaces",
     *      example="CLI"
     * )
     *
     * @var string
     */
    public $interfaces;

    /**
     * @OA\Property(
     *     title="Created at",
     *     description="Created at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $created_at;

    /**
     * @OA\Property(
     *     title="Updated at",
     *     description="Updated at",
     *     example="2020-01-27 17:50:45",
     *     format="datetime",
     *     type="string"
     * )
     *
     * @var \DateTime
     */
    private $updated_at;

    /**
     * @OA\Property(
     *      title="Name and version",
     *      description="Catalogue entry name and version",
     *      example="PHP v7.3.13"
     * )
     *
     * @var string
     */
    public $name_version;
}
