<?php

namespace App\Http\Middleware;

use App\Http\Ajax\Action;
use App\Http\Ajax\Response;
use Closure;
use Redirect;
use Illuminate\Contracts\Auth\Guard;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard $auth
     * @return self
     */
    public function __construct(Guard $auth)
    {
        \Config::set('debugbar.enabled', false);
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                Response::attachAction(Action::LOGOUT);
                throw new AccessDeniedHttpException;
            } else {
                return Redirect::route('home');
            }
        }

        return $next($request);
    }
}
