<?php

namespace SocialiteProviders\Cognito;

use SocialiteProviders\Manager\SocialiteWasCalled;

class CognitoExtendSocialite
{
    /**
     * Execute the provider.
     */
    public function handle(SocialiteWasCalled $socialiteWasCalled)
    {
        $socialiteWasCalled->extendSocialite('cognito', __NAMESPACE__.'\Provider');
    }
}
