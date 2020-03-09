<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable
{
    use Notifiable;
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'email_verified_at', 'password', 'provider_name', 'provider_id', 'admin', 'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static $logAttributes = [
                'name', 'email', 'email_verified_at', 'provider_name', 'provider_id', 'admin', 'role',
    ];

    /**
     * Check if the user is an admin.
     *
     * @return boolean
     */
    public function isAdmin()
    {
        return $this->admin == 1;
    }

    /**
     * Check if the user is in the reader role.
     *
     * @return boolean
     */
    public function isReader()
    {
        return $this->role == 'reader';
    }

    /**
     * Check if the user is in the contributor role.
     *
     * @return boolean
     */
    public function isContributor()
    {
        return $this->role == 'contributor';
    }
}
