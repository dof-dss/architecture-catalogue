<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StaticPagesTest extends TestCase
{
    /**
     * Home page availability test
     *
     * @return void
     */
    public function testHomePageIsReachable()
    {
        // if we have not logged in we should be redirected to the login page
        $response = $this->get('/home');
        $response->assertStatus(302);
    }

    /**
     * Login page test
     *
     * @return void
     */
    public function testLoginPageIsReachable()
    {
        // if we have not logged in we should be redirected to the login page
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    /**
     * Accessibility page test
     *
     * @return void
     */
    public function testAccessibilityPageIsReachable()
    {
        // if we have not logged in we should be redirected to the login page
        $response = $this->get('/accessibility');
        $response->assertSee('Accessbility statement');
    }

    /**
     * Cookies page test
     *
     * @return void
     */
    public function testCookiesPageIsReachable()
    {
        // if we have not logged in we should be redirected to the login page
        $response = $this->get('/cookies');
        $response->assertSee('Cookies');
        $response->assertSee('privacy policy');
        $response->assertSee('/privacy-policy');
    }

    /**
     * Privacy policy page test
     *
     * @return void
     */
    public function testPrivacyPolicyPageIsReachable()
    {
        // if we have not logged in we should be redirected to the login page
        $response = $this->get('/privacy-policy');
        $response->assertSee('Privacy policy');
        $response->assertSee('contact us');
        $response->assertSee('ea-team@ea.finance-ni.gov.uk');
    }
}
