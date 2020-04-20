<?php

namespace SocialiteProviders\Cognito;

use Illuminate\Support\Arr;
use SocialiteProviders\Cognito\User;
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
            'name'     => $user['email'],
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

    // ***
    // * need to override the default code in order to extract id_token
    // ***

    /**
     * @return \SocialiteProviders\Cognito\User;
     */
    public function user()
    {
        if ($this->hasInvalidState()) {
            throw new InvalidStateException();
        }

        $response = $this->getAccessTokenResponse($this->getCode());
        $this->credentialsResponseBody = $response;

        $user = $this->mapUserToObject($this->getUserByToken(
            $token = $this->parseAccessToken($response)
        ));

        if ($user instanceof User) {
            $user->setAccessTokenResponseBody($this->credentialsResponseBody);
        }

        return $user->setToken($token)
                    ->setRefreshToken($this->parseRefreshToken($response))
                    ->setExpiresIn($this->parseExpiresIn($response))
                    ->setIdToken($this->parseIdToken($response));
    }

    /**
     * Get the access token from the token response body.
     *
     * @param string $body
     *
     * @return string
     */
    protected function parseIdToken($body)
    {
        return Arr::get($body, 'id_token');
    }
}
