<?php

namespace App\Http\Livewire\Admin;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class Storage extends Component
{
    use WithPagination;

    public $searchKey = '', $perPage = 10, $status = '', $inStore = 0;
    public $queryString = [
        'searchKey'=>['except'=>''],
        'status'=>['except'=>''],
        'inStore'=>['except'=>0],
        'perPage'=>['except'=>10]
    ];
    public function render()
    {
        $items = Product::with('owner','category','unity','incharge1','item','warehouse','slot')
                        ->where('out',$this->inStore)
                        ->when($this->searchKey, function($query){
                            $query->whereHas('owner', function($query2){
                               $query2->where('name','like','%'.$this->searchKey.'%'); 
                               $query2->orWhere('phone','like','%'.$this->searchKey.'%'); 
                               $query2->orWhere('email','like','%'.$this->searchKey.'%'); 
                            });
                        })->when($this->status, function($query3){
                            $query3->where('status',$this->status); 
                        })
                        ->orderByDesc('created_at')
                        ->paginate($this->perPage);
        $all = Product::where('out',0)->count();
        $pending = Product::where('out',0)->where('status','Pending')->count();
        $approved = Product::where('out',0)->where('status','Approved')->count();
        $denied = Product::where('out',0)->where('status','Denied')->count();
        return view('livewire.admin.storage', compact('items','all','pending','denied','approved'));
    }
}
