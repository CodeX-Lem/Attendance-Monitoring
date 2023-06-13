<?php

namespace App\Http\Middleware;

use App\Models\UserModel;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class IsTrainor
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

        if (Session::get('isAdmin') == false) {
            $trainorId = Session::get('trainor_id');
            $trainor = UserModel::where('trainor_id', '=', $trainorId)->first();
            View::share(['currentUser' => $trainor]);
            return $next($request);
        } else {
            Session::forget('isAdmin');
            Session::forget('trainor_id');
            return redirect('/')->with('message', 'Only trainors can access this module');
        }
    }
}