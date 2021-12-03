<?php

namespace App\Http\Livewire\Admin;

use App\Models\Warehouse;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;

class Warehouses extends Component
{
    use WithPagination;
    public $searchKey = '', $perPage = 10;
    public $queryString = [
        'searchKey'=>['except'=>''],
        'perPage'=>['except'=>10]
    ];

    public function delete($id)
    {
        $wh = Warehouse::findOrfail($id);
        if ($wh->picture) {
            Storage::disk('public')->delete($wh->picture);
        }
        // if  it has some products and manager throw back an error logic will go here
        $wh->delete();
        session()->flash('success','Warehouse Deleted Successfully!');
    }
    public function render()
    {
        $warehouses = Warehouse::with('manager')
        // ->withCount('products')
                                ->where('name','like','%'.$this->searchKey.'%')
                                ->orWhere('email','like','%'.$this->searchKey.'%')
                                ->orWhere('phone','like','%'.$this->searchKey.'%')
                                ->orderBy('name')->paginate($this->perPage);
        return view('livewire.admin.warehouses', compact('warehouses'));
    }
}
