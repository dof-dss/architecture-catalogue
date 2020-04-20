<?php

namespace SocialiteProviders\Cognito;

use SocialiteProviders\Manager\OAuth2\User as SocialiteProviderUser;

class User extends SocialiteProviderUser
{
    /**
     * The Cognito id_token
     */
    public $idToken;

    /**
     * Set the id_token on the user.
     *
     * Might include things such as the token and refresh token
     *
     * @param string $id_token
     *
     * @return $this
     */
    public function setIdToken($id_token)
    {
        $this->idToken = $id_token;
        return $this;
    }
}
