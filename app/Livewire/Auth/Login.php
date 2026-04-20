<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public $username;
    public $password;

    public function login()
    {
        $this->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = [
            'username' => $this->username,
            'password' => $this->password,
        ];

        if (Auth::attempt($credentials)) {
            session()->regenerate();


            $role = Auth::user()->role;

            if ($role === 'Kepala_IT') {
                return redirect()->route('kepala.dashboard');
            } elseif ($role === 'Teknisi') {
                return redirect()->route('teknisi.dashboard');
            } else {
                return redirect()->route('user.dashboard');
            }
        }

        $this->addError('username', 'Username atau password salah');
    }

    public function render()
    {
        return view('livewire.auth.login');
    }
}
