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
        if (!Session::has('isAdmin')) {
            return redirect('/')->with('message', 'You have to login first');
        }

        if (Session::get('isAdmin') == true) {
            View::share(['adminUsername' => env('ADMIN_USERNAME'), 'adminPassword' => env('ADMIN_PASSWORD')]);
            return $next($request);
        } else {
            Session::forget('isAdmin');
            return redirect('/')->with('message', 'Please log in as admin to continue');
        }
    }
}
