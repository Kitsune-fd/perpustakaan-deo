<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Pengguna extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Services\PenggunaService::class;
    }
}
