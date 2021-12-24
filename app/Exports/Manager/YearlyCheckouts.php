<?php

namespace App\Exports\Manager;
use App\Models\Activity;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class YearlyCheckouts implements FromQuery, WithMapping, WithHeadings,WithCustomStartCell,WithTitle,ShouldAutoSize
{
    private $year,$month;

    public function __construct(int $year, int $month)
    {
        $this->year = $year;
        $this->month = $month;
    }
    public function query()
    {
        return Activity::with('user','product')
        ->where('type', 'Checkout')
        ->where('warehouse_id',Auth::user()->warehouse->id)
        ->whereMonth('created_at',$this->month)->whereYear('created_at',$this->year);
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

    public function title(): string
    {
        return DateTime::createFromFormat('!m',$this->month)->format('F');
    }
}
