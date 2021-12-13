<?php

namespace App\Http\Livewire\Manager;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Clients extends Component
{
    public $search = '', $status = '', $perPage = 5;
    use WithPagination;
    public $queryString = [
        'search'=>['except'=>''],
        'status'=>['except'=>''],
        'perPage'=>['except'=>5]
    ];
    public function render()
    {
        $product = json_encode(Product::where('warehouse_id',Auth::user()->warehouse->id)->distinct('owner_id')->pluck('owner_id'));
        $arr =[];
        foreach(json_decode($product) as $item){
            $arr[] = $item;
        } 

        $clients = User::where('role','Client')->whereIn('id',$arr)
        ->whereRelation('items','warehouse_id',Auth::user()->warehouse->id)
        ->with('province','district','sector','cell','items')
        // ->when('search',function($query){
        //     $query->orWhere('name','like','%'.$this->search.'%')
        //             ->orWhere('phone','like','%'.$this->search.'%')
        //             ->orWhere('email','like','%'.$this->search.'%')
        //             ;
        // })
        ->orderBy('name')->paginate($this->perPage);

        return view('livewire.manager.clients',compact('clients'));
    }
}
