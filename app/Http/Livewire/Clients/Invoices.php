<?php

namespace App\Http\Livewire\Clients;

use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Invoices extends Component
{
    use WithPagination;
    public $searchKey = '', $perPage, $confirmed = '';
    public $queryString = [
        'searchKey'=>['except'=>''],
        'confirmed'=>['except'=>''],
        'perPage'=>['except'=>10]
    ];

    public function render()
    {
        $items = Invoice::with('warehouse','product')->where('user_id',Auth::id())
                        ->when($this->searchKey, function($query){
                            $query->where('code','like','%'.$this->searchKey.'%');
                        })
                        ->when($this->confirmed, function($query3){
                            $query3->where('confirmed',$this->confirmed); 
                        })
                        ->orderByDesc('created_at')
                        ->paginate($this->perPage);
        return view('livewire.clients.invoices', compact('items'));
    }
}
