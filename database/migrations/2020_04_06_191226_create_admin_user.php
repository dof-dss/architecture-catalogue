<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

use App\User;

class CreateAdminUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $user = new User;
        $user->uuid = $user->getUuid();
        $user->name = 'admin';
        $user->email = config('app.admin_username');
        $user->password = Hash::make(config('app.admin_password'));
        $user->provider_name = 'setup';
        $user->provider_id = '0';
        $user->admin = 1;
        $user->role = 'contributor';
        $user->saveWithoutEvents();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        User::where('name', 'admin')
            ->first()
            ->delete();
    }
}
