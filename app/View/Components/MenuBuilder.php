<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MenuBuilder extends Component
{
    public $menuItems;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($menuItems)
    {
        $this->menuItems = $menuItems;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.menu-builder');
    }
}
