<?php

namespace App\Livewire\Component;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Navbar extends Component
{

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
    public function render()
    {
        return view('livewire.component.navbar');
    }
}
