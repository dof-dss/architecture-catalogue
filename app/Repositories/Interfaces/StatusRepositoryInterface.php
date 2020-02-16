<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface StatusRepositoryInterface
{
    public function all();
    public function labels();
}
