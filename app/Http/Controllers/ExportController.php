<?php

namespace App\Http\Controllers;

use App\Exports\Manager\Checkins;
use App\Exports\Manager\CheckinsMultisheets;
use App\Exports\Manager\Checkouts;
use App\Exports\Manager\CheckoutsMultisheets;
use App\Exports\Manager\Outgoings;
use App\Exports\Manager\OutgoingsMultisheet;
use App\Exports\Manager\Requests;
use App\Exports\Manager\RequestsMultisheet;
use App\Exports\Manager\Transfers;
use App\Exports\Manager\TransfersMultisheet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Excel;

class ExportController extends Controller
{
    public function warehouseMonthlyRequests(Excel $excel)
    {
        return $excel->download(new Requests(), Auth::user()->warehouse->code.' '.date('F').' Requests.xlsx');
    }

    public function warehouseMonthlyCheckouts(Excel $excel)
    {
        return $excel->download(new Checkouts(), Auth::user()->warehouse->code.' '.date('F').' Checkouts.xlsx');
    }

    public function warehouseMonthlyCheckins(Excel $excel)
    {
        return $excel->download(new Checkins(), Auth::user()->warehouse->code.' '.date('F').' Checkins.xlsx');
    }

    public function warehouseMonthlyOutgoings(Excel $excel)
    {
        return $excel->download(new Outgoings(), Auth::user()->warehouse->code.' '.date('F').' Outgoing Transfers.xlsx');
    }

    public function warehouseMonthlyTransfer(Excel $excel)
    {
        return $excel->download(new Transfers(), Auth::user()->warehouse->code.' '.date('F').' Incoming Transfers.xlsx');
    }

    public function YearlyCheckins(Excel $excel)
    {
        return $excel->download(new CheckinsMultisheets(date('Y')),Auth::user()->warehouse->code.' '.date('Y').' Checkins.xlsx');
    }

    public function YearlyCheckouts(Excel $excel)
    {
        return $excel->download(new CheckoutsMultisheets(date('Y')),Auth::user()->warehouse->code.' '.date('Y').' Checkouts.xlsx');
    }

    public function YearlyTransfers(Excel $excel)
    {
        return $excel->download(new TransfersMultisheet(date('Y')),Auth::user()->warehouse->code.' '.date('Y').' Incoming Transfers.xlsx');
    }

    public function YearlyOutgoings(Excel $excel)
    {
        return $excel->download(new OutgoingsMultisheet(date('Y')),Auth::user()->warehouse->code.' '.date('Y').' Outgoing Transfers.xlsx');
    }

    public function YearlyRequests(Excel $excel)
    {
        return $excel->download(new RequestsMultisheet(date('Y')),Auth::user()->warehouse->code.' '.date('Y').' Requests.xlsx');
    }
}
