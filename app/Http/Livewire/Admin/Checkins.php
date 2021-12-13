<?php

namespace App\Http\Livewire\Admin;

use App\Models\Activity;
use Livewire\Component;
use Livewire\WithPagination;

class Checkins extends Component
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
        $items = Activity::with('user','product','warehouse')
                        ->where('type', 'Checkin')
                        ->when($this->searchKey, function($query){
                            $query->whereHas('user', function($query2){
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
        $all = Activity::where('type', 'Checkin')->count();
        $pending = Activity::where('status','Pending')->where('type', 'Checkin')->count();
        $approved = Activity::where('status','Approved')->where('type', 'Checkin')->count();
        $denied = Activity::where('status','Rejected')->where('type', 'Checkin')->count();
        return view('livewire.admin.checkins',compact('items','all','pending','denied','approved'));
    }
}
