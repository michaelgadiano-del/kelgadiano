<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class RoleBadge extends Component
{
    public function __construct(public string $role = 'Student')
    {
    }

    public function color(): string
    {
        return match ($this->role) {
            'Admin' => 'red',
            'Teacher' => 'blue',
            'Student' => 'green',
            default => 'gray',
        };
    }

    public function render(): View
    {
        return view('components.role-badge');
    }
}
