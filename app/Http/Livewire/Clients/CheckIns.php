<?php

namespace App\Http\Livewire\Clients;

use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CheckIns extends Component
{
    use LivewireAlert;
    use WithPagination;
    public $status = '', $perPage = 5;

    public $queryString = [
        'status'=>['except'=>''],
        'perPage'=>['except'=>5]
    ];

    public function revert($id)
    {
        $activity = Activity::findOrFail($id);
        $activity->delete();
        $this->alert('success', 'Check-In Request Reverted Successfully!', [
            'position' => 'top-end',
            'timer' => 4000,
            'width' => '600',
            'toast' => true,
        ]);
    }

    public function render()
    {
        $checkins = Activity::with('user','warehouse','product')->where('type','Checkin')
        ->where('user_id',Auth::id())->when($this->status, function($query){
            $query->where('status',$this->status);
        })->paginate($this->perPage);
        $all = Activity::where('type','Checkin')->where('user_id',Auth::id())->count();
        $pending = Activity::where('type','Checkin')->where('user_id',Auth::id())->where('status','Pending')->count();
        $approved = Activity::where('type','Checkin')->where('user_id',Auth::id())->where('status','Approved')->count();
        $denied = Activity::where('type','Checkin')->where('user_id',Auth::id())->where('status','Denied')->count();
        return view('livewire.clients.check-ins', compact('checkins','pending','approved','denied','all'));
    }
}
