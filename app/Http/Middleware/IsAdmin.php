<?php

namespace App\Http\Middleware;

use App\Models\UserModel;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Session::has('loginId')) {
            return redirect('/')->with('message', 'You have to login first');
        }

        $user = UserModel::where('id', '=', Session::get('loginId'))->first();

        if ($user->role == 1) {
            View::share('currentUser', $user);
            return $next($request);
        } else {
            Session::forget('loginId');
            return redirect('/')->with('message', 'Please log in as admin to continue');
        }
    }
}
