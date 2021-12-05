<?php

namespace App\Http\Livewire\Clients;

use App\Models\Item;
use Livewire\Component;

class Request extends Component
{
    public $products;
    public function mount()
    {
        $this->products = Item::select('name','id')->orderBy('name')->get();
    }
    public function render()
    {
        return view('livewire.clients.request');
    }
}
