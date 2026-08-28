<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    public $type;

    public function __construct($type = 'info')
    {
        $this->type = $type;
    }

    public function render()
    {
        return view('components.alert');
    }

    public function message()
    {
        return $this->type === 'error' ? 'Something went wrong!' : 'Action successful!';
    }
}