<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Search extends Component
{
    /**
     * Create a new component instance.
     */
    public $searchRoute;
    public $addRoute;
    public $searchMessage;
    public function __construct($searchRoute,$addRoute, $searchMessage)
    {
        //
        $this->searchRoute = $searchRoute;
        $this->addRoute = $addRoute;
        $this->searchMessage = $searchMessage;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.search');
    }
}