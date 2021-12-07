<?php

namespace App\Http\Livewire\Clients;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Items extends Component
{
    use WithPagination;
    public $search = '', $perPage = 5;

    public $queryString = [
        'search'=>['except'=>''],
        'perPage'=>['except'=>5]
    ];
    public function render()
    {
        $items = Product::with('warehouse','slot','item','unity','incharge')->where('owner_id',Auth::id())
                        ->where('until','>=',date('Y-m-d'))
                        ->paginate($this->perPage);
        return view('livewire.clients.items', compact('items'));
    }
}
