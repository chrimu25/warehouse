<?php

namespace App\Exports\Admin;

use App\Models\Activity;
use DateTime;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class Checkouts implements FromQuery, WithMapping,WithHeadings,WithCustomStartCell,WithTitle,ShouldAutoSize
{
    private $year,$month;

    public function __construct(int $year, int $month)
    {
        $this->year = $year;
        $this->month = $month;
    }

    public function query()
    {
        return Activity::with('user','product','warehouse')
        ->where('type', 'Checkout')
        ->whereMonth('created_at',$this->month)->whereYear('created_at',$this->year);
    }

    public function map($checkout): array
    {
        return [
            $checkout->product->item?$checkout->product->item->name:'',
            $checkout->quantity,
            $checkout->product?$checkout->product->quantity:'',
            $checkout->product->unity?$checkout->product->unity->name:'',
            $checkout->user?$checkout->user->name:'',
            $checkout->product->warehouse?$checkout->product->warehouse->name:'',
            $checkout->product->slot?$checkout->product->slot->name:'',
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

    public function title(): string
    {
        return DateTime::createFromFormat('!m',$this->month)->format('F');
    }
}
