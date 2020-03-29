<?php

namespace Tests\Unit;

use Tests\TestCase;

use App\Services\Authorisation as AuthService;
use App\Exceptions\AuthException as AuthException;

use Illuminate\Support\Str;

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

    /**
     * Inject authorisation token.
     *
     * @return void
     */
    public function testInjectAuthorisationToken()
    {
        $authService = new AuthService;
        $params = [];
        $params = $authService->injectAuthorisationToken($params);
        $this->assertTrue(Str::contains($params['Authorization'], 'Bearer'));
    }

    /**
     * Authorisation token exception.
     *
     * @return void
     */
    public function testAuthorisationException()
    {
        $this->expectException(AuthException::class);

        // force the authorisation to fail by providing bad credentials
        config()->set('eaaudit.cognito_user', 'user');
        config()->set('eaaudit.cognito_password', 'password');
        $authService = new AuthService;
        $token = $authService->getAuthorisationToken();

        $this->assertException(AuthException::class);
    }
}
