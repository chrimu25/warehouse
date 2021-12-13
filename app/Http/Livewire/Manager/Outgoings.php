<?php

namespace App\Http\Livewire\Manager;

use App\Models\Transfer;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Outgoings extends Component
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
        $item = Transfer::findOrfail($id);
        $item->delete();
        $this->alert('success', 'Transfer Request Deleted Successfully!', [
            'position' => 'top-right',
            'timer' => 4000,
            'toast' => true,
            'width' => '500',
        ]);
    }
    
    public function Approve($id)
    {
        $transfer = Transfer::findOrFail($id);
        $transfer->update([
            'approved'=>1,
            'incharge'=>Auth::id(),
        ]);
        $this->alert('success', 'Transfer Allowed Successfully!', [
            'position' => 'top-right',
            'timer' => 4000,
            'toast' => true,
            'width' => '500',
        ]);
    }

    public function render()
    {
        $transfers = Transfer::with('owner1','toWarehouse','unity','product')
                        ->where('from',Auth::user()->warehouse->id)
                        ->where('approved',0)
                        ->when($this->searchKey, function($query){
                            $query->whereHas('owner1', function($query2){
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
        $all = Transfer::where('from',Auth::user()->warehouse->id)->where('approved',0)->count();
        $pending = Transfer::where('status','Pending')
                        ->where('approved',0)
                        ->where('from',Auth::user()->warehouse->id)->count();
        $approved = Transfer::where('status','Approved')
                        ->where('approved',0)
                        ->where('from',Auth::user()->warehouse->id)->count();
        $denied = Transfer::where('status','Denied')
                        ->where('approved',0)
                        ->where('from',Auth::user()->warehouse->id)->count();

        return view('livewire.manager.outgoings',compact('transfers','all','pending','denied','approved'));
    }
}
