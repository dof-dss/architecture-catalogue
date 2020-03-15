<?php

return [

  /*
  |--------------------------------------------------------------------------
  | GOV.UK Notify Key
  |--------------------------------------------------------------------------
  |
  */
  'govuk_notify_apikey' => env('GOVUK_NOTIFY_API_KEY'),

  /*
  |--------------------------------------------------------------------------
  | GOV.UK Notify email template ids
  |--------------------------------------------------------------------------
  |
  */
  'user_welcome_template_id' => env('GOVUK_NOTIFY_USER_WELCOME_TEMPLATE_ID'),
  'password_reset_template_id' => env('GOVUK_NOTIFY_PASSWORD_RESET_TEMPLATE_ID')
];
