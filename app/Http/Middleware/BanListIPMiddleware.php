<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Models\BlackListIP;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;
use Closure;

class BanListIPMiddleware {

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
    public function __construct(Guard $auth) {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        
        $model_IP = new BlackListIP();
        //Kiem tra trong db
        $check = $model_IP->checkIPBan();
        if($check == false){// ko tim thay ip bi ban
            return $next($request);
        }
        return view('errors.maintained');
    }

}
