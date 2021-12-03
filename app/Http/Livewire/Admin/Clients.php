<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class Clients extends Component
{
    use WithPagination;
    public $searchKey = '', $perPage = 10;
    public $queryString = [
        'searchKey'=>['except'=>''],
        'perPage'=>['except'=>10]
    ];

    public function block($id)
    {
        $client = User::findOrfail($id);
        $client->update(['status'=>!$client->status]);
        session()->flash('success','Status Changed Successfully!');
    }
    public function render()
    {
        $clients = User::with(['province','district','sector','cell'])->where('role','Client')
                        ->orderBy('name')->paginate($this->perPage);
        return view('livewire.admin.clients', compact('clients'));
    }
}
