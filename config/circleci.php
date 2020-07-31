<?php

return [
    /*
    |--------------------------------------------------------------------------
    | CircleCI environment variables
    |--------------------------------------------------------------------------
    |
    | Used to pick up CircleCI information when building using CircleCI
    |
    */
    'branch' => env('CIRCLE_BRANCH', exec('git branch --show-current')),
    'pull_request' => env('CIRCLE_PULL_REQUEST', exec("git config --get remote.origin.url | sed 's/\.git/\/pulls/'"))
];
