<?php

namespace App\Http\Livewire\Admin;

use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Invoices extends Component
{
    use WithPagination;
    public $searchKey = '', $perPage, $item, $confirmed = 1;
    public $queryString = [
        'searchKey'=>['except'=>''],
        'confirmed'=>['except'=>1],
        'perPage'=>['except'=>10]
    ];
    public function render()
    {
        $items = Invoice::with('owner','product','warehouse')
                        ->when($this->searchKey, function($query){
                            $query->whereHas('owner', function($query2){
                               $query2->where('name','like','%'.$this->searchKey.'%'); 
                               $query2->orWhere('phone','like','%'.$this->searchKey.'%'); 
                               $query2->orWhere('email','like','%'.$this->searchKey.'%'); 
                            });
                        })->where('confirmed',$this->confirmed)
                        ->orderByDesc('created_at')
                        ->paginate($this->perPage);
        return view('livewire.admin.invoices',compact('items'));
    }
}
