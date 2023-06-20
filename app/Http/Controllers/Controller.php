<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $like = '';

    public function __construct()
    {
        $databaseDriver = config('database.connections.' . config('database.default') . '.driver');
        $this->like = $databaseDriver == 'pgsql' ? 'ilike' : 'like';
    }
}
