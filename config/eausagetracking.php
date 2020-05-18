<?php

return [
    /*
    |--------------------------------------------------------------------------
    | NICS EA Usage Tracking tenant id
    |--------------------------------------------------------------------------
    |
    */
    'enabled' => env('NICS_EA_USAGE_TRACKING_ENABLED', true),
    'api' => env('NICS_EA_USAGE_TRACKING_API'),
    'tenant_name' => env('NICS_EA_USAGE_TRACKING_TENANT_NAME'),
    'tenant_id' => env('NICS_EA_USAGE_TRACKING_TENANT_ID'),
    'account_created_event_id' => env('NICS_EA_USAGE_TRACKING_ACCOUNT_CREATED_EVENT_ID')
];
