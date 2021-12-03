<?php

namespace App\Http\Livewire\Manager;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Clients extends Component
{
    public $search = '', $perPage = 5;
    use WithPagination;
    public $queryString = [
        'search'=>['except'=>''],
        'perPage'=>['except'=>5]
    ];
    public function render()
    {
        // $clients = Product::where('warehouse_id',Auth::user()->warehouse->id)->with('owner')->paginate($this->perPage);
        $clients = Auth::user()->warehouse->clients;
        return view('livewire.manager.clients',compact('clients'));
    }
}
