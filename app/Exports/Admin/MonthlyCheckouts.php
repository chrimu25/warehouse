<?php

namespace App\Exports\Admin;

use App\Models\Activity;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MonthlyCheckouts implements FromQuery, WithMapping,WithHeadings,WithCustomStartCell,ShouldAutoSize
{
    public function query()
    {
        return Activity::with('user','product','warehouse')
        ->where('type', 'Checkout')
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
            $checkout->product->warehouse->name,
            $checkout->product->slot->name,
            $checkout->status,
            $checkout->created_at->format('Y-m-d'),
        ];
    }

    public function headings(): array
    {
        return ['Item','Checkout Quantity', 'Quantity','Unity',"Owner", "Warehouse",'Slot', 'Status', 'Created At'];
    }

    public function startCell(): string
    {
        return "B3";
    }
}
