<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class alertSweet extends Component
{
    /**
     * Create a new component instance.
     */
    public string $type;
    public string $message;
    public function __construct(string $type = 'success', string $message)
    {
        $this->type = $type;
        $this->message = $message;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.alert-sweet');
    }
}
