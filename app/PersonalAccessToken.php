<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Traits\AuditsActivity;

class PersonalAccessToken extends Model
{
    use AuditsActivity;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'token',
    ];
}
