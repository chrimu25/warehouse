<?php

namespace App\Http\Livewire\Admin;

use App\Models\Cell;
use App\Models\District;
use App\Models\Province;
use App\Models\Sector;
use Livewire\Component;

class Locations extends Component
{
    public $districts = null, $sectors = null, $cells = null;
    public $province, $district, $sector, $cell;

    public function updatedProvince($province)
    {
        $this->districts = District::where('province_id',$province)
        ->orderBy('name')->select('name','id')->get();
    }

    function updatedDistrict($district){
        $this->sectors = Sector::where('district_id',$district)
        ->orderBy('name')->select('name','id')->get();
    }

    function updatedSector($sector){
        $this->cells = Cell::where('sector_id',$sector)
        ->orderBy('name')->select('name','id')->get();
    }

    public function render()
    {
        $provinces = Province::orderBy('name')->get();
        return view('livewire.admin.locations',compact('provinces'));
    }
}
