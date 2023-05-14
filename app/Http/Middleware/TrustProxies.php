<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Symfony\Component\HttpFoundation\Request as RequestAlias;

class TrustProxies extends Middleware
{
    /**
     * TДоверенные прокси для этого приложения
     *
     * @var array<int, string>|string|null
     */
    protected $proxies;

    /**
     * Заголовки, которые следует использовать для обнаружения прокси
     *
     * @var int
     */
    protected $headers =
        RequestAlias::HEADER_X_FORWARDED_FOR |
        RequestAlias::HEADER_X_FORWARDED_HOST |
        RequestAlias::HEADER_X_FORWARDED_PORT |
        RequestAlias::HEADER_X_FORWARDED_PROTO |
        RequestAlias::HEADER_X_FORWARDED_AWS_ELB;
}
