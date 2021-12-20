<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Transfer;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function dashboard()
    {
        // dd('som');
        $wh = Warehouse::where('active',1)->count();
        $clients = User::where('role','Client')->where('status',1)->count();

        // $product = json_encode(Product::where('warehouse_id',Auth::user()->warehouse->id)->distinct('owner_id')->pluck('owner_id'));
        // $arr =[];
        // foreach(json_decode($product) as $item){
        //     $arr[] = $item;
        // } 
        // $whclients = User::whereIn('id',$arr)->count();
        

        $wh = Warehouse::where('active',1)->count();
        $clients = User::where('role','Client')->where('status',1)->count();
        $checkins = json_encode($this->getMonthlyActivities());
        $transfers = json_encode($this->getMonthlyTransfer());
        $requests = json_encode($this->getMonthlyRequests());
        $totalCheckins = json_encode($this->getMonthlyCheckins());
        $checkinspie = $this->getMonthlyCheckinsPie();

        $totalCheckouts = json_encode($this->getMonthlyCheckouts());
        $checkoutspie = $this->getMonthlyCheckoutsPie();
        $transferpie = $this->getMonthlyTransferPie();
        $requestpie = $this->getMonthlyRequestsPie();

        // $whcheckouts = $this->getWarehouseCheckouts();
        // $whcheckins = $this->getWarehouseCheckins();

        // $whinrequests = $this->getWarehouseRequests();
        // $whoutrequests = $this->getWarehouseOutRequests();

        // dd($checkinspie);
        return view('dashboard', compact(
            'wh',
            'clients',
            'checkins',
            'transfers',
            'requests',
            'totalCheckins',
            'checkinspie',
            'totalCheckouts',
            'checkoutspie',
            'transferpie',
            'requestpie',
            // 'whcheckouts',
            // 'whcheckins',
            // 'whinrequests',
            // 'whoutrequests',
            // 'whclients',
        ));
    }

    public function getMonthlyActivities()
    {
        $checkins = Activity::select(DB::raw("COUNT(*) as count"))->whereYear('created_at',date('Y'))
        ->groupBy(DB::raw("Month(created_at)"))->pluck('count');

        $months1 = Activity::where('status','approved')->where('type','Checkin')
        ->select(DB::raw("Month(created_at) as months"))->whereYear('created_at',date('Y'))
        ->groupBy(DB::raw("Month(created_at)"))->pluck('months');

        $approved_checkins = array(0,0,0,0,0,0,0,0,0,0,0,0);
        foreach($months1 as $index => $month){
            $approved_checkins[$month] = $checkins[$index];
        }
        
        return $approved_checkins;
    }

    public function getMonthlyTransfer()
    {
        $transfers = Transfer::select(DB::raw("COUNT(*) as count"))->whereYear('created_at',date('Y'))
        ->groupBy(DB::raw("Month(created_at)"))->pluck('count');

        $months1 = Transfer::select(DB::raw("Month(created_at) as months"))->whereYear('created_at',date('Y'))
        ->groupBy(DB::raw("Month(created_at)"))->pluck('months');

        $approved_transfers = array(0,0,0,0,0,0,0,0,0,0,0,0);
        foreach($months1 as $index => $month){
            $approved_transfers[$month] = $transfers[$index];
        }
        
        return $approved_transfers;
    }

    public function getMonthlyRequests()
    {
        $requests = Product::select(DB::raw("COUNT(*) as count"))->whereYear('created_at',date('Y'))
        ->groupBy(DB::raw("Month(created_at)"))->pluck('count');

        $months1 = Product::select(DB::raw("Month(created_at) as months"))->whereYear('created_at',date('Y'))
        ->groupBy(DB::raw("Month(created_at)"))->pluck('months');

        $approved_requests = array(0,0,0,0,0,0,0,0,0,0,0,0);
        foreach($months1 as $index => $month){
            $approved_requests[$month] = $requests[$index];
        }
        
        return $approved_requests;
    }

    public function getMonthlyCheckins()
    {
        $checkins = Activity::
        where('type','Checkin')->
        select(DB::raw("COUNT(*) as count"))->whereYear('created_at',date('Y'))
        ->groupBy(DB::raw("Month(created_at)"))->pluck('count');

        $months1 = Activity::
        where('type','Checkin')->
        select(DB::raw("Month(created_at) as months"))->whereYear('created_at',date('Y'))
        ->groupBy(DB::raw("Month(created_at)"))->pluck('months');

        $total_checkins = array(0,0,0,0,0,0,0,0,0,0,0,0);
        foreach($months1 as $index => $month){
            $total_checkins[$month] = $checkins[$index];
        }
        
        return $total_checkins;
    }

    public function getMonthlyCheckinsPie()
    {
        $checkinpie = [];
        $monthly_pending_activities = Activity::where('type','Checkin')->where('status','Pending')
        ->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count();

        $monthly_approved_activities = Activity::where('type','Checkin')->where('status','Approved')
        ->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count();

        $monthly_denied_activities = Activity::where('type','Checkin')->where('status','Denied')
        ->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->count();

        array_push($checkinpie,$monthly_pending_activities,$monthly_approved_activities,$monthly_denied_activities);

        return json_encode($checkinpie);
    }

    public function getMonthlyCheckouts()
    {
        $checkins = Activity::
        where('type','Checkout')->
        select(DB::raw("COUNT(*) as count"))->whereYear('created_at',date('Y'))
        ->groupBy(DB::raw("Month(created_at)"))->pluck('count');

        $months1 = Activity::
        where('type','Checkout')->
        select(DB::raw("Month(created_at) as months"))->whereYear('created_at',date('Y'))
        ->groupBy(DB::raw("Month(created_at)"))->pluck('months');

        $total_checkins = array(0,0,0,0,0,0,0,0,0,0,0,0);
        foreach($months1 as $index => $month){
            $total_checkins[$month] = $checkins[$index];
        }
        
        return $total_checkins;
    }

    public function getMonthlyCheckoutsPie()
    {
        $checkoutpie = [];
        $monthly_pending_activities = Activity::where('type','Checkout')->where('status','Pending')
        ->whereYear('created_at', date('Y'))->count();

        $monthly_approved_activities = Activity::where('type','Checkout')->where('status','Approved')
        ->whereYear('created_at', date('Y'))->count();

        $monthly_denied_activities = Activity::where('type','Checkout')->where('status','Denied')
        ->whereYear('created_at', date('Y'))->count();

        array_push($checkoutpie,$monthly_pending_activities,$monthly_approved_activities,$monthly_denied_activities);

        return json_encode($checkoutpie);
    }

    public function getMonthlyTransferPie()
    {
        $transferspie = [];
        $monthly_pending_transfers = Transfer::where('status','Pending')
        ->whereYear('created_at', date('Y'))->count();

        $monthly_approved_transfers = Transfer::where('status','Approved')
        ->whereYear('created_at', date('Y'))->count();

        $monthly_denied_transfers = Transfer::where('status','Denied')
        ->whereYear('created_at', date('Y'))->count();

        array_push($transferspie,$monthly_pending_transfers,$monthly_approved_transfers,$monthly_denied_transfers);

        return json_encode($transferspie);
    }

    public function getMonthlyRequestsPie()
    {
        $requestspie = [];
        $monthly_pending_requests = Product::where('status','Pending')
        ->whereYear('created_at', date('Y'))->count();

        $monthly_approved_requests = Product::where('status','Approved')
        ->whereYear('created_at', date('Y'))->count();

        $monthly_denied_requests = Product::where('status','Denied')
        ->whereYear('created_at', date('Y'))->count();

        array_push($requestspie,$monthly_pending_requests,$monthly_approved_requests,$monthly_denied_requests);

        return json_encode($requestspie);
    }

    public function getWarehouseCheckouts()
    {
        $warehouse_checkouts = Activity::where('warehouse_id',Auth::user()->warehouse->id)->
        where('type','Checkout')->
        select(DB::raw("COUNT(*) as count"))->whereYear('created_at',date('Y'))
        ->groupBy(DB::raw("Month(created_at)"))->pluck('count');

        $months1 = Activity::where('warehouse_id',Auth::user()->warehouse->id)->
        where('type','Checkout')->
        select(DB::raw("Month(created_at) as months"))->whereYear('created_at',date('Y'))
        ->groupBy(DB::raw("Month(created_at)"))->pluck('months');

        $total_warehouse_checkouts = array(0,0,0,0,0,0,0,0,0,0,0,0);
        foreach($months1 as $index => $month){
            $total_warehouse_checkouts[$month] = $warehouse_checkouts[$index];
        }
        
        return json_encode($total_warehouse_checkouts);
    }

    public function getWarehouseCheckins()
    {
        $warehouse_checkins = Activity::where('warehouse_id',Auth::user()->warehouse->id)->
        where('type','Checkin')->
        select(DB::raw("COUNT(*) as count"))->whereYear('created_at',date('Y'))
        ->groupBy(DB::raw("Month(created_at)"))->pluck('count');

        $months1 = Activity::where('warehouse_id',Auth::user()->warehouse->id)->
        where('type','Checkin')->
        select(DB::raw("Month(created_at) as months"))->whereYear('created_at',date('Y'))
        ->groupBy(DB::raw("Month(created_at)"))->pluck('months');

        $total_warehouse_checkins = array(0,0,0,0,0,0,0,0,0,0,0,0);
        foreach($months1 as $index => $month){
            $total_warehouse_checkins[$month] = $warehouse_checkins[$index];
        }
        
        return json_encode($total_warehouse_checkins);
    }

    public function getWarehouseRequests()
    {
        $requests = Product::where('warehouse_id',Auth::user()->warehouse->id)
        ->where('out',0)
        ->select(DB::raw("COUNT(*) as count"))->whereYear('created_at',date('Y'))
        ->groupBy(DB::raw("Month(created_at)"))->pluck('count');

        $months1 = Product::where('warehouse_id',Auth::user()->warehouse->id)
        ->where('out',0)
        ->select(DB::raw("Month(created_at) as months"))->whereYear('created_at',date('Y'))
        ->groupBy(DB::raw("Month(created_at)"))->pluck('months');

        $approved_requests = array(0,0,0,0,0,0,0,0,0,0,0,0);
        foreach($months1 as $index => $month){
            $approved_requests[$month] = $requests[$index];
        }
        
        return json_encode($approved_requests);
    }

    public function getWarehouseOutRequests()
    {
        $requests = Product::where('warehouse_id',Auth::user()->warehouse->id)
        ->where('out',1)
        ->select(DB::raw("COUNT(*) as count"))->whereYear('created_at',date('Y'))
        ->groupBy(DB::raw("Month(created_at)"))->pluck('count');

        $months1 = Product::where('warehouse_id',Auth::user()->warehouse->id)
        ->where('out',1)
        ->select(DB::raw("Month(created_at) as months"))->whereYear('created_at',date('Y'))
        ->groupBy(DB::raw("Month(created_at)"))->pluck('months');

        $outrequests = array(0,0,0,0,0,0,0,0,0,0,0,0);
        foreach($months1 as $index => $month){
            $outrequests[$month] = $requests[$index];
        }
        
        return json_encode($outrequests);
    }
}
