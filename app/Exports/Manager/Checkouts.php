<?php

namespace App\Exports\Manager;

use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class Checkouts implements FromQuery, WithMapping,WithHeadings,WithCustomStartCell,ShouldAutoSize
{
    public function query()
    {
        return Activity::with('user','product')
        ->where('type', 'Checkout')
        ->where('warehouse_id',Auth::user()->warehouse->id)
        ->whereMonth('created_at',date('m'))->whereYear('created_at',date('Y'));
    }

    public function map($checkout): array
    {
        return [
            $checkout->product->item->name,
            $checkout->quantity,
            $checkout->product->quantity,
            $checkout->product->unity->name,
            $checkout->user->name,
            $checkout->product->slot->name,
            $checkout->status,
            $checkout->created_at->format('Y-m-d'),
        ];
    }

    public function headings(): array
    {
        return ['Item','Checkout Quantity', 'Quantity','Unity',"Owner",'Slot', 'Status', 'Created At'];
    }

    public function startCell(): string
    {
        return "B3";
    }
}
