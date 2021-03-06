<?php

namespace App\Http\Livewire\Manager;

use App\Models\Activity;
use App\Models\Product;
use App\Models\User;
use App\Notifications\CheckoutApprovedNotification;
use App\Notifications\CheckoutDeniedNotification;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class Checkouts extends Component
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
        DeleteCheckout($id);
        $this->alert('success', 'Checkout Request Deleted Successfully!', [
            'position' => 'top-right',
            'timer' => 4000,
            'toast' => true,
            'width' => '500',
        ]);
    }

    public function Deny($id)
    {
        DenyCheckout($id);
        $this->alert('success', 'Checkout Request Rejected Successfully!', [
            'position' => 'top-right',
            'timer' => 4000,
            'toast' => true,
            'width' => '500',
        ]);
    }
    
    public function Approve($id)
    {
        ApproveCheckout($id);
        $this->alert('success', 'Checkout Request Approved Successfully!', [
            'position' => 'top-right',
            'timer' => 4000,
            'toast' => true,
            'width' => '500',
        ]);
    }

    public function render()
    {
        $items = Activity::with('user','product')
                        ->where('type', 'Checkout')
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
        $all = Activity::where('type', 'checkout')
                        ->where('warehouse_id',Auth::user()->warehouse->id)->count();
        $pending = Activity::where('status','Pending')->where('type', 'checkout')
                        ->where('warehouse_id',Auth::user()->warehouse->id)->count();
        $approved = Activity::where('status','Approved')->where('type', 'checkout')
                        ->where('warehouse_id',Auth::user()->warehouse->id)->count();
        $denied = Activity::where('status','Rejected')->where('type', 'checkout')
                        ->where('warehouse_id',Auth::user()->warehouse->id)->count();
        return view('livewire.manager.checkouts',compact('items','all','pending','denied','approved'));
    }
}
