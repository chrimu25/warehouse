<?php

namespace App\Http\Livewire\Clients;

use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class CheckOuts extends Component
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
        $this->alert('success', 'Check-Out Request Reverted Successfully!', [
            'position' => 'top-end',
            'timer' => 4000,
            'width' => '600',
            'toast' => true,
        ]);
    }

    public function render()
    {
        $checkouts = Activity::with('user','warehouse','product')->where('type','Checkout')
        ->where('user_id',Auth::id())->when($this->status, function($query){
            $query->where('status',$this->status);
        })->paginate($this->perPage);
        $all = Activity::where('type','Checkout')->where('user_id',Auth::id())->count();
        $pending = Activity::where('type','Checkout')->where('user_id',Auth::id())->where('status','Pending')->count();
        $approved = Activity::where('type','Checkout')->where('user_id',Auth::id())->where('status','Approved')->count();
        $denied = Activity::where('type','Checkout')->where('user_id',Auth::id())->where('status','Denied')->count();
        return view('livewire.clients.check-outs',compact('checkouts','pending','approved','denied','all'));
    }
}
