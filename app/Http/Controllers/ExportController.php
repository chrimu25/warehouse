<?php

namespace App\Http\Controllers;

use App\Exports\Admin\CheckinsMultisheet;
use App\Exports\Admin\CheckoutsMultisheet;
use App\Exports\Admin\MonthlyCheckins;
use App\Exports\Admin\MonthlyCheckouts;
use App\Exports\Admin\MonthlyStore;
use App\Exports\Admin\MonthlyTransfers;
use App\Exports\Admin\StoreMultisheet;
use App\Exports\Admin\TransfersMultisheet as AdminTransfersMultisheet;
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

    // Super Admin Export
    public function MOnthlyCheckins(Excel $excel)
    {
        return $excel->download(new MonthlyCheckins(), config('app.name').' '.date('F').' Checkins.xlsx');
    }

    public function AllYearlyCheckins(Excel $excel)
    {
        return $excel->download(new CheckinsMultisheet(date('Y')),config('app.name').' '.date('Y').' Checkins.xlsx');
    }

    public function MOnthlyCheckouts(Excel $excel)
    {
        return $excel->download(new MonthlyCheckouts(), config('app.name').' '.date('F').' Checkouts.xlsx');
    }

    public function AllYearlyCheckouts(Excel $excel)
    {
        return $excel->download(new CheckoutsMultisheet(date('Y')),config('app.name').' '.date('Y').' Checkouts.xlsx');
    }

    public function MOnthlyTransfers(Excel $excel)
    {
        return $excel->download(new MonthlyTransfers(), config('app.name').' '.date('F').' transfers.xlsx');
    }

    public function AllYearlyTransfers(Excel $excel)
    {
        return $excel->download(new AdminTransfersMultisheet(date('Y')),config('app.name').' '.date('Y').' transfers.xlsx');
    }

    public function MOnthlyStore(Excel $excel)
    {
        return $excel->download(new MonthlyStore(), config('app.name').' '.date('F').' Requests.xlsx');
    }

    public function AllYearlyStore(Excel $excel)
    {
        return $excel->download(new StoreMultisheet(date('Y')),config('app.name').' '.date('Y').' Requests.xlsx');
    }

}
