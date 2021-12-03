<?php

namespace App\Http\Livewire\Manager;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class NewClient extends Component
{
    public $name, $email, $phone, $nid;
    protected $rules = [
        'name'=>'bail|required|string|min:3|max:255',
        'email'=>'nullable|email|string|min:4|max:200|unique:users,email',
        'phone'=>'required|size:10|unique:users,phone',
        'nid'=>'required|size:16|unique:users,nid'
    ];

    protected $attributes = [
        'nid'=>'National ID'
    ];

    public function insert()
    {
        $this->validate();
        User::create([
            'name'=>$this->name,
            'email'=>$this->email,
            'password'=>Hash::make('Client@password'),
            'phone'=>$this->phone,
            'role'=>'Client',
            'nid'=>$this->nid,
        ]);

        $this->emit('InsertItemsComponent');
        $this->reset();

        return back()->with('success','New Client Inserted Successfully');
    }
    public function render()
    {
        return view('livewire.manager.new-client');
    }
}
