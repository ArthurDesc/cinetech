<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Comments extends Component
{
    public $tmdbId;
    public $type;

    public function __construct($tmdbId, $type)
    {
        $this->tmdbId = $tmdbId;
        $this->type = $type;
    }

    public function render()
    {
        return view('components.comments');
    }
}
