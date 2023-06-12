<?php

namespace App\View\Composers;

use App\Models\TrainorModel;
use Illuminate\View\View;

class TrainorComposer
{
    public function compose(View $view): void
    {
        $view->with('trainors', TrainorModel::all());
    }
}
