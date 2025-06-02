<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class UserDashboard extends Component
{
    public $orders = [];
    public $favorites = [];

    public function mount()
    {
        $response = Http::withToken(session('api_token'))
                        ->get(config('app.url') . '/api/user/dashboard');
        
        if ($response->ok()) {
            $data = $response->json();
            $this->orders = $data['orders'] ?? [];
            $this->favorites = $data['favorites'] ?? [];
        }
    }

    public function render()
    {
        return view('livewire.user-dashboard');
    }
}