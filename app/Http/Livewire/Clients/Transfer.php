<?php

namespace App\Http\Livewire\Clients;

use App\Models\Transfer as ModelsTransfer;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Transfer extends Component
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
        $transfer = ModelsTransfer::findOrFail($id);
        $transfer->delete();
        $this->alert('success', 'Transfer Request Reverted Successfully!', [
            'position' => 'top-end',
            'timer' => 4000,
            'width' => '600',
            'toast' => true,
        ]);
    }

    public function render()
    {
        $transfers = ModelsTransfer::with('fromWarehouse','toWarehouse','slot','product','category')
        ->where('owner',Auth::id())->when($this->status, function($query){
            $query->where('status',$this->status);
        })->paginate($this->perPage);

        $all = ModelsTransfer::where('owner',Auth::id())->count();
        $pending = ModelsTransfer::where('owner',Auth::id())->where('status','Pending')->count();
        $approved = ModelsTransfer::where('owner',Auth::id())->where('status','Approved')->count();
        $denied = ModelsTransfer::where('owner',Auth::id())->where('status','Denied')->count();
        return view('livewire.clients.transfer', compact('transfers','pending','approved','denied','all'));
    }
}
