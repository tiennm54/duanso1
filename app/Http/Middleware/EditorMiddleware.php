<?php

namespace App\Http\Middleware;
use App\Models\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

use Closure;

class EditorMiddleware
{

    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            $user = $this->auth->user();
            if ($user) {
                $model_user = User::find($user->id);
                if ($model_user->role->alias == "admin" || $model_user->role->alias == "editor") {
                    return $next($request);
                }
            }
        }
        return redirect()->route('users.getLogin');

    }
}
