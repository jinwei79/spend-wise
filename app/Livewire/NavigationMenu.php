<?php

namespace App\Http\Livewire;

use Livewire\Component;

class NavigationMenu extends Component
{
    public $sidebarOpen = true;

    public function toggleSidebar()
    {
        $this->sidebarOpen = !$this->sidebarOpen;
    }

    public function render()
    {
        return view('livewire.navigation-menu');
    }
}
