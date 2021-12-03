<?php

namespace App\Http\Livewire\Admin;

use App\Models\Unity;
use Livewire\Component;
use Livewire\WithPagination;

class Unities extends Component
{
    public $name, $search = '', $perPage = 5;
    public $selected_id, $open = false;
    use WithPagination;
    public $queryString = [
        'search'=>['except'=>''],
        'perPage'=>['except'=>5]
    ];

    public function store()
    {
        $this->validate(['name'=>'required|string|max:100|min:3|unique:unities,name']);
        Unity::create([
            'name'=>$this->name,
        ]);
        $this->reset();
    }

    public function edit($id)
    {
        $unity = Unity::findOrFail($id);
        $this->name = $unity->name;
        $this->selected_id = $unity->id;
        $this->open = true;
    }

    public function update($id)
    {
        $unity = Unity::findOrFail($id);
        $this->validate(['name'=>'required|string|unique:unities,name,'.$unity->id]);
        $unity->name = $this->name;
        $unity->save();
        $this->reset();
        $this->open = false;
    }

    public function delete($id)
    {
        $unity = Unity::findOrFail($id);
        $unity->delete();
    }

    public function render()
    {
        $unities = Unity::where('name','like','%'.trim($this->search).'%')
                                ->orderBy('name')->simplePaginate($this->perPage);
        return view('livewire.admin.unities',compact('unities'));
    }
}
