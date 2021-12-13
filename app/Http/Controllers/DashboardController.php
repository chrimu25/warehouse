<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function dashboard()
    {
        $transfers = Transfer::where('status','approved')->select(DB::raw("COUNT(*) as count"))
                        ->whereYear('created_at',date('Y'))
                        ->groupBy(DB::raw("Month(created_at)"))->pluck('count');
        $months = Transfer::where('status','approved')->select(DB::raw("Month(created_at) as months"))
                        ->whereYear('created_at',date('Y'))
                        ->groupBy(DB::raw("Month(created_at)"))->pluck('months');
        $approved_transfers = array(0,0,0,0,0,0,0,0,0,0,0,0);
        foreach($months as $index => $month){
            $approved_transfers[$month] = $transfers[$index];
        }

        $checkins = Activity::where('status','approved')->where('type','Checkin')
        ->select(DB::raw("COUNT(*) as count"))->whereYear('created_at',date('Y'))
        ->groupBy(DB::raw("Month(created_at)"))->pluck('count');

        $months1 = Activity::where('status','approved')->where('type','Checkin')
        ->select(DB::raw("Month(created_at) as months"))->whereYear('created_at',date('Y'))
        ->groupBy(DB::raw("Month(created_at)"))->pluck('months');

        $approved_checkins = array(0,0,0,0,0,0,0,0,0,0,0,0);
        foreach($months1 as $index => $month){
            $approved_checkins[$month] = $transfers[$index];
        }

        $checkouts = Activity::where('status','approved')->where('type','Checkout')
        ->select(DB::raw("COUNT(*) as count"))->whereYear('created_at',date('Y'))
        ->groupBy(DB::raw("Month(created_at)"))->pluck('count');

        $months2 = Activity::where('status','approved')->where('type','Checkout')
        ->select(DB::raw("Month(created_at) as months"))->whereYear('created_at',date('Y'))
        ->groupBy(DB::raw("Month(created_at)"))->pluck('months');

        $approved_checkouts = array(0,0,0,0,0,0,0,0,0,0,0,0);
        foreach($months2 as $index => $month){
            $approved_checkouts[$month] = $transfers[$index];
        }

        return view('dashboard', compact('approved_transfers','approved_checkins','approved_checkouts'));
    }
}
