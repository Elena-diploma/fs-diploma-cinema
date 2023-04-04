<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

class EncryptCookies extends Middleware
{
    /**
     * файлы cookie, которые не должны быть зашифрованы
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
}
