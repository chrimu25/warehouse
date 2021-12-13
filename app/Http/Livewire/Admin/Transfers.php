<?php

namespace App\Http\Livewire\Admin;

use App\Models\Transfer;
use Livewire\Component;
use Livewire\WithPagination;

class Transfers extends Component
{
    use WithPagination;
    
    public $searchKey = '', $perPage, $item, $status;
    public $queryString = [
        'searchKey'=>['except'=>''],
        'status'=>['except'=>''],
        'perPage'=>['except'=>10]
    ];

    public function render()
    {
        $transfers = Transfer::with('owner1','fromWarehouse','toWarehouse','unity','slot','product')
                        ->where('approved',1)
                        ->when($this->searchKey, function($query){
                            $query->whereHas('owner1', function($query2){
                               $query2->where('name','like','%'.$this->searchKey.'%'); 
                               $query2->orWhere('phone','like','%'.$this->searchKey.'%'); 
                               $query2->orWhere('email','like','%'.$this->searchKey.'%'); 
                            });
                        })
                        ->when($this->status, function($query3){
                            $query3->where('status',$this->status); 
                        })
                        ->orderBy('created_at')
                        ->paginate($this->perPage);
        $all = Transfer::where('approved',1)->count();
        $pending = Transfer::where('status','Pending')->where('approved',1)->count();
        $approved = Transfer::where('status','Approved')->where('approved',1)->count();
        $denied = Transfer::where('status','Denied')->where('approved',1)->count();
        
        return view('livewire.admin.transfers',compact('transfers','all','pending','denied','approved'));
    }
}
