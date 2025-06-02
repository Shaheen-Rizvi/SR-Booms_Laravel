<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class AdminDashboard extends Component
{
    public $orders;
    public $flowers;
    public $stats = [];

    public function mount()
    {
        $response = Http::withToken(session('api_token'))
                        ->get(config('app.url') . '/api/admin/dashboard');
        
        if ($response->ok()) {
            $data = $response->json();
            $this->orders = $data['recent_orders'] ?? [];
            $this->flowers = $data['low_stock_flowers'] ?? [];
            $this->stats = $data['stats'] ?? [];
        }
    }

    public function render()
    {
        return view('livewire.admin-dashboard')->layout('layouts.guest');
    }
}
