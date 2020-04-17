<?php

namespace SocialiteProviders\Cognito;

use SocialiteProviders\Manager\OAuth2\User;
use Laravel\Socialite\Two\ProviderInterface;
use SocialiteProviders\Manager\OAuth2\AbstractProvider;

use Illuminate\Support\Facades\Log;

class Provider extends AbstractProvider implements ProviderInterface
{
    /**
     * Unique Provider Identifier.
     */
    const IDENTIFIER = 'COGNITO';

    /**
     * {@inheritdoc}
     */
    protected $scopes = [''];

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        Log::debug(__FUNCTION__);
        return $this->buildAuthUrlFromBase(
            config('services.cognito.auth_domain') . '/oauth2/authorize',
            $state
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        Log::debug(__FUNCTION__);
        return config('services.cognito.auth_domain') . '/oauth2/token';
    }

    /**
     * {@inheritdoc}
     */
    public function getAccessToken($code)
    {
        Log::debug(__FUNCTION__);
        $response = $this->getHttpClient()->post($this->getTokenUrl(), [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            'form_params' => $this->getTokenFields($code)
            ]
        ]);
        $this->credentialsResponseBody = json_decode($response->getBody(), true);
        return $this->parseAccessToken($response->getBody());
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        Log::debug(__FUNCTION__);
        $response = $this->getHttpClient()->get(config('services.cognito.auth_domain') . '/oauth2/userInfo', [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);
        return json_decode($response->getBody(), true);
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        Log::debug(__FUNCTION__);
        Log::debug(print_r($user, true));
        return (new User())->setRaw($user)->map([
            'id'       => $user['sub'],
            'nickname' => $user['username'],
            'name'     => $user['username'],
            'email'    => $user['email'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenFields($code)
    {
        Log::debug(__FUNCTION__);
        return array_merge(parent::getTokenFields($code), [
            'grant_type' => 'authorization_code',
            'client_id' => config('services.cognito.client_id'),
            'redirect_uri' => config('app.url') . config('services.cognito.redirect')
        ]);
    }
}
