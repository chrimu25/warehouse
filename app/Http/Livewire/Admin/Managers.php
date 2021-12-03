<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Managers extends Component
{
    use WithPagination;
    public $searchKey = '', $perPage = 10;
    public $queryString = [
        'searchKey'=>['except'=>''],
        'perPage'=>['except'=>10]
    ];

    public function delete($id)
    {
        $manager = User::findOrfail($id);
        $manager->delete();
        session()->flash('success','Warehouse Deleted Successfully!');
    }

    public function block($id)
    {
        $manager = User::findOrfail($id);
        $manager->update(['status'=>!$manager->status]);
        session()->flash('success','Status Changed Successfully!');
    }
    public function render()
    {
        $managers = User::with('warehouse')->where('role','Manager')
                        ->orderBy('name')->paginate($this->perPage);
        return view('livewire.admin.managers',compact('managers'));
    }
}
