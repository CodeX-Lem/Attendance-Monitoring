<?php

namespace App\Providers;

use App\View\Composers\TrainorComposer;
use App\View\Composers\CourseComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        View::composer(['admin.courses.create', 'admin.courses.edit'], TrainorComposer::class);
        View::composer(['admin.students.create', 'admin.students.index'], CourseComposer::class);
    }
}
