<?php

namespace App\Http\Livewire\Manager;

use App\Models\Activity;
use App\Models\Product;
use App\Models\User;
use App\Notifications\CheckinApprovedNotification;
use App\Notifications\CheckinDeniedNotification;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Checkins extends Component
{
    use WithPagination;
    use LivewireAlert;
    public $searchKey = '', $perPage, $item, $status;
    public $queryString = [
        'searchKey'=>['except'=>''],
        'status'=>['except'=>''],
        'perPage'=>['except'=>10]
    ];

    public function delete($id)
    {
        DeleteCheckin($id);
        session()->flash('success','Checkin Request Deleted Successfully!');
    }

    public function Deny($id)
    {
        DenyCheckin($id);
        $this->alert('success', 'Checkin Request Rejected Successfully!', [
            'position' => 'top-right',
            'timer' => 4000,
            'toast' => true,
            'width' => '500',
        ]);
    }
    
    public function Approve($id)
    {
        ApproveCheckin($id);
        
        $this->alert('success', 'Checkin Request Approved Successfully!', [
            'position' => 'top-right',
            'timer' => 4000,
            'toast' => true,
            'width' => '500',
        ]);
    }

    public function render()
    {
        $items = Activity::with('user','product')
                        ->where('type', 'Checkin')
                        ->where('warehouse_id',Auth::user()->warehouse->id)
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
        $all = Activity::where('type', 'Checkin')
                        ->where('warehouse_id',Auth::user()->warehouse->id)->count();
        $pending = Activity::where('status','Pending')->where('type', 'Checkin')
                        ->where('warehouse_id',Auth::user()->warehouse->id)->count();
        $approved = Activity::where('status','Approved')->where('type', 'Checkin')
                        ->where('warehouse_id',Auth::user()->warehouse->id)->count();
        $denied = Activity::where('status','Rejected')->where('type', 'Checkin')
                        ->where('warehouse_id',Auth::user()->warehouse->id)->count();
        return view('livewire.manager.checkins',compact('items','all','pending','denied','approved'));
    }
}
