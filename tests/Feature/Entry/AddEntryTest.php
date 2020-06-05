<?php

namespace Tests\Feature\Entry;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Event;

use App\User;
use App\Entry;

use App\Repositories\Eloquent\StatusRepository as StatusRepository;

use \Illuminate\Support\Str;

class AddEntryTest extends TestCase
{
    /**
     * Check a contributor can see the add entry button
     *
     * @return void
     */
    public function testAContributorCanViewAddCatalogueEntryButton()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        $user = $this->loginAsFakeUser(false, 'contributor');
        $response = $this->get(route('home'));
        $response->assertSuccessful();
        $response->assertSee('Add a new entry');
    }

    /**
     * Check reader can't see the add entry button
     *
     * @return void
     */
    public function testAReaderCannotViewAddCatalogueEntryButton()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        $user = $this->loginAsFakeUser(false, 'reader');
        $response = $this->get(route('home'));
        $response->assertSuccessful();
        $response->assertDontSee('Add a new entry');
    }

    /**
     * Check contributor can create entry
     *
     * @return void
     */
    public function testContributorCanAddValidCatalogueEntry()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        $user = $this->loginAsFakeUser(false, 'contributor');

        // stops events being fired
        Event::fake();

        $entry = factory(Entry::class)->make([
            'href' => 'www.hp.com'
        ]);
        $this->followingRedirects()
            ->from(route('entry.create'))
            ->post(route('entry.store'), [
            'name' =>  $entry->name,
            'version' => $entry->version,
            'description' => $entry->description,
            'href' => $entry->href,
            // category and sub_category are sent through from the UI like this
            'category_subcategory' => $entry->category . "-" . $entry->sub_category,
            'status' => $entry->status,
            'functionality' => $entry->functionality,
            'service_levels' => $entry->service_levels,
            'interfaces' => $entry->interfaces
            ])
            ->assertSee($entry->name);
    }

    /**
     * Check contributor can't create duplicate
     *
     * @return void
     */
    public function testContributorCannotAddDuplicateCatalogueEntry()
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        $user = $this->loginAsFakeUser(false, 'contributor');

        // stops events being fired
        Event::fake();

        $entry = factory(Entry::class)->create();
        $this->followingRedirects()
            ->from(route('entry.create'))
            ->post(route('entry.store'), [
                'name' =>  $entry->name,
                'version' => $entry->version,
                'description' => 'duplicate entry test',
                'href' => $entry->href,
                // category and sub_category are sent through from the UI like this
                'category_subcategory' => $entry->category . "-" . $entry->sub_category,
                'status' => $entry->status,
                'functionality' => $entry->functionality,
                'service_levels' => $entry->service_levels,
                'interfaces' => $entry->interfaces
            ])
            ->assertSuccessful()
            ->assertSee('There is a problem')
            ->assertSee('An entry with this name and version already exists.')
            ->assertSee('An entry with this version and name already exists.');

        $this->assertDatabaseMissing('entries', [
            'description' => 'duplicate entry test'
        ]);
    }

    //
    // Individual validation checks
    // ============================
    //

    // name

    /**
     * Check that name is required
     *
     * @return void
     */
    public function testEntryValidationNameRequired()
    {
        $this->validationCheck(
            ['name' => ''],
            'Enter the component name.'
        );
    }

    /**
     * Check that name is not too short
     *
     * @return void
     */
    public function testEntryValidationNameTooShort()
    {
        $this->validationCheck(
            ['name' => 'NA'],
            'Name must be between 3 and 40 characters.'
        );
    }

    /**
     * Check that name is not too long
     *
     * @return void
     */
    public function testEntryValidationNameTooLong()
    {
        $this->validationCheck(
            ['name' => Str::random(41)],
            'Name must be between 3 and 40 characters.'
        );
    }

    // version

    /**
     * Check version for invalid characters
     *
     * @return void
     */
    public function testEntryValidationVersionInvalidCharacters()
    {
        $this->validationCheck(
            ['version' => '!inv@lidchacter$'],
            'Version must only include letters, digits, spaces and punctuation.'
        );
    }

    /**
     * Check that version is not too long
     *
     * @return void
     */
    public function testEntryValidationVersionTooLong()
    {
        $this->validationCheck(
            ['version' => Str::random(21)],
            'Version must be between 1 and 20 characters.'
        );
    }

    // description

    /**
     * Check that description is required
     *
     * @return void
     */
    public function testEntryValidationDescriptionRequired()
    {
        $this->validationCheck(
            ['description' => ''],
            'Enter a description.'
        );
    }

    /**
     * Check description for invalid characters
     *
     * @return void
     */
    public function testEntryValidationDescriptionInvalidCharacters()
    {
        $this->validationCheck(
            ['description' => '!inv@lidchacter$'],
            'Description must only include letters, digits, spaces and punctuation.'
        );
    }

    /**
     * Check that description is not too short
     *
     * @return void
     */
    public function testEntryValidationDescriptionTooShort()
    {
        $this->validationCheck(
            ['description' => 'De'],
            'Description must be between 3 and 100 characters.'
        );
    }

    /**
     * Check that description is not too long
     *
     * @return void
     */
    public function testEntryValidationDescriptionTooLong()
    {
        $this->validationCheck(
            ['description' => Str::random(101)],
            'Description must be between 3 and 100 characters.'
        );
    }

    // product page URL

    /**
     * Check URL for invalid characters
     *
     * @return void
     */
    public function testEntryValidationInvalidUrl()
    {
        $this->validationCheck(
            ['href' => 'invalid@url'],
            'The URL is invalid.'
        );
        $this->validationCheck(
            ['href' => 'http://thistestsite'],
            'The URL is invalid.'
        );
    }

    /**
     * Check that URL is not too long
     *
     * @return void
     */
    public function testEntryValidationUrlTooLong()
    {
        $longUrl = 'https://www.example.com/' .
            '123456789012345678901234567890123456789012345678901234567890' .
            '123456789012345678901234567890123456789012345678901234567890' .
            '123456789012345678901234567890123456789012345678901234567890' .
            '123456789012345678901234567890123456789012345678901234567890' .
            '123456789012345678901234567890123456789012345678901234567890';
        $this->validationCheck(
            ['href' => $longUrl],
            'The associated URL must be 250 characters or fewer.'
        );
    }


    // category / sub_category

    /**
     * Check that category_subcategory is required
     *
     * @return void
     */
    public function testEntryValidationCategorySubcategoryRequired()
    {
        $this->validationCheck(
            ['category_subcategory' => ''],
            'Enter a category and subcategory.'
        );
    }

    /**
     * Check category_subcategory for invalid characters
     *
     * @return void
     */
    public function testEntryValidationCategorySubcategoryInvalidCharacters()
    {
        $this->validationCheck(
            ['category_subcategory' => '!inv@lidchacter$'],
            'Category and subcategory must only include letters, digits, spaces and punctuation.'
        );
    }

    /**
     * Check that category_subcategory is not too short
     *
     * @return void
     */
    public function testEntryValidationCategorySubcategoryTooShort()
    {
        $this->validationCheck(
            ['category_subcategory' => 'short'],
            'Category and subcategory must be between 8 and 80 characters.'
        );
    }

    /**
     * Check that category_subcategory is not too long
     *
     * @return void
     */
    public function testEntryValidationCategorySubcategoryTooLong()
    {
        $this->validationCheck(
            ['category_subcategory' => Str::random(81)],
            'Category and subcategory must be between 8 and 80 characters.'
        );
    }

    // status

    /**
     * Check that status is required
     *
     * @return void
     */
    public function testEntryValidationStatusRequired()
    {
        $this->validationCheck(
            ['status' => ''],
            'Enter a status.'
        );
    }

    /**
     * Check status for invalid characters
     *
     * @return void
     */
    public function testEntryValidationStatusInvalidCharacters()
    {
        $this->validationCheck(
            ['status' => '!inv@lid'],
            'Status must only include letters.'
        );
    }

    /**
     * Check that status is not too long
     *
     * @return void
     */
    public function testEntryValidationStatusTooLong()
    {
        $this->validationCheck(
            ['status' => 'abcdefghijk'],
            'Status must be 10 characters or fewer.'
        );
    }

    // functionality

    /**
     * Check that functionality is not too long
     *
     * @return void
     */
    public function testEntryValidationFunctionalityTooLong()
    {
        $this->validationCheck(
            ['functionality' => Str::random(301)],
            'upported functionality must 300 characters or fewer.'
        );
    }

    /**
     * Check that a URL can be entered as a data
     *
     * @return void
     */
    public function testEntryValidationFunctionalityCanContainUrl()
    {
        $this->validationCheck(
            ['functionality' => 'https://architecture-catalogue.test'],
            'must only include',
            'assertDontSee'
        );
    }

    // service levels

    /**
     * Check that service levels is not too long
     *
     * @return void
     */
    public function testEntryValidationServiceLevelsTooLong()
    {
        $this->validationCheck(
            ['service_levels' => Str::random(301)],
            'Service levels must be 300 characters or fewer.'
        );
    }

    /**
     * Check that a URL can be entered as a data
     *
     * @return void
     */
    public function testEntryValidationServiceLevelsCanContainUrl()
    {
        $this->validationCheck(
            ['service_levels' => 'https://architecture-catalogue.test'],
            'must only include',
            'assertDontSee'
        );
    }

    // interfaces

    /**
     * Check that interfaces is not too long
     *
     * @return void
     */
    public function testEntryValidationInterfacesTooLong()
    {
        $this->validationCheck(
            ['interfaces' => Str::random(301)],
            'Interfaces must be 300 characters or fewer.'
        );
    }

    /**
     * Check that a URL can be entered as a data
     *
     * @return void
     */
    public function testEntryValidationInterfacesCanContainUrl()
    {
        $this->validationCheck(
            ['interfaces' => 'https://architecture-catalogue.test'],
            'must only include',
            'assertDontSee'
        );
    }

    // *************************************************************************

    /**
     * Checks validation conditions for the specified item
     *
     * @param array $item
     * @param string $message
     * @return response
     */
    private function validationCheck($item, $message, $visualCheck = 'assertSee')
    {
        // stops notification being physically sent when a user is created
        Notification::fake();

        $user = $this->loginAsFakeUser(false, 'contributor', $visualCheck);

        // stops events being fired
        Event::fake();

        // mock up an entry
        $entry = factory(Entry::class)->make();
        $payload = [
            'name' =>  $entry->name,
            'version' => $entry->version,
            'description' => $entry->description,
            'href' => $entry->href,
            // category and sub_category are sent through from the UI like this
            'category_subcategory' => $entry->category . "-" . $entry->sub_category,
            'status' => $entry->status,
            'functionality' => $entry->functionality,
            'service_levels' => $entry->service_levels,
            'interfaces' => $entry->interfaces
        ];

        // replace the field being tested in the payload
        $key = key($item);
        $payload[$key] = $item[$key];

        // attempt to store the data
        $this->followingRedirects()
            ->from(route('entry.create'))
            ->post(route('entry.store'), $payload)
            ->assertSuccessful()
            ->$visualCheck($message);
    }
}
