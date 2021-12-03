<?php

namespace App\Http\Livewire\Admin;

use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class Categories extends Component
{
    public $category, $newName, $search = '', $perPage = 5;
    public $selected_id, $open = false;
    use WithPagination;
    public $queryString = [
        'search'=>['except'=>''],
        'perPage'=>['except'=>5]
    ];

    public function updated($fields)
    {
        $this->validateOnly($fields, 
        ['category'=>'required|string|max:100|min:3|unique:categories,name']);
    }

    public function store()
    {
        $this->validate(['category'=>'required|string|max:100|min:3|unique:categories,name']);
        Category::create([
            'name'=>$this->category,
            'slug'=>Str::slug($this->category)
        ]);
        $this->reset();
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        $this->category = $category->name;
        $this->newName = $category->name;
        $this->selected_id = $category->id;
        $this->open = true;
    }

    public function update($id)
    {
        $category = Category::findOrFail($id);
        $this->validate(['category'=>'required|string|unique:categories,name,'.$category->id]);
        $category->name = $this->category;
        $category->slug = Str::slug($this->category);
        $category->save();
        $this->reset();
        $this->open = false;
    }

    public function delete($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
    }

    public function render()
    {
        $categories = Category::where('name','like','%'.trim($this->search).'%')
                                ->orderBy('name')->simplePaginate($this->perPage);
        return view('livewire.admin.categories',compact('categories'));
    }
}
