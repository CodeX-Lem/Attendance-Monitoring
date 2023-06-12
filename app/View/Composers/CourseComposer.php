<?php

namespace App\View\Composers;

use App\Models\CourseModel;
use Illuminate\View\View;

class CourseComposer
{
    public function compose(View $view): void
    {
        $view->with('courses', CourseModel::all());
    }
}
