<?php

namespace App\Http\Middleware;

use Closure;

class LoadPages
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		\Config::set('app.name', option('app.name','ZlatKit'));
		\Config::set('mail.host', option('smtp-host','smtp.yandex.ru'));
		\Config::set('mail.port', option('smtp-port','587'));
		\Config::set('mail.from', ['address'=>option('smtp-username','user@yandex.ru'),'name'=>config('app.name')]);
		\Config::set('mail.username', option('smtp-username','user@yandex.ru'));
		\Config::set('mail.password', option('smtp-password',''));
		\Config::set('mail.encryption', option('smtp-encryption','tls'));
        return $next($request);
    }
}
