<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class TeacherLayout extends Component
{
    public string $active;
    public string $title;

    public function __construct(string $active = 'dashboard', string $title = 'Teacher Portal')
    {
        $this->active = $active;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.teacher');
    }
}

