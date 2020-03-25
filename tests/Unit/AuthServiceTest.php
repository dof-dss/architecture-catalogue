<?php

namespace Tests\Unit;

use Tests\TestCase;

use App\Services\Authorisation as AuthService;

class AuthServiceTest extends TestCase
{
    /**
     * Authorisation token creation.
     *
     * @return void
     */
    public function testGetAuthorisationToken()
    {
        $authService = new AuthService;
        $token = $authService->getAuthorisationToken();
        $this->assertTrue(is_string($token));
    }
}
