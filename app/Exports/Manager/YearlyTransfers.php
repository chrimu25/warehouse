<?php

namespace App\Exports\Manager;

use App\Models\Transfer;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class YearlyTransfers implements FromQuery, WithMapping, WithHeadings,WithCustomStartCell,WithTitle,ShouldAutoSize
{
    private $year,$month;

    public function __construct(int $year, int $month)
    {
        $this->year = $year;
        $this->month = $month;
    }
    
    public function query()
    {
        return Transfer::with('owner1','toWarehouse','unity','product')
        ->where('to',Auth::user()->warehouse->id)
        ->where('approved',1)
        ->whereMonth('created_at',$this->month)->whereYear('created_at',$this->year);;
    }

    public function map($transfer): array
    {
        return [
            $transfer->owner1?$transfer->owner1->name:'',
            $transfer->product?$transfer->product->item->name:'',
            $transfer->quantity,
            $transfer->product?$transfer->product->quantity:'',
            $transfer->product?$transfer->product->unity->name:'',
            $transfer->toWarehouse?$transfer->toWarehouse->name:'',
            $transfer->status,
            $transfer->created_at->format('Y-m-d'),
        ];
    }

    public function headings(): array
    {
        return ['Owner','Item', 'Transfer Quantity', 'Quantity','Unity',"Warehouse", 'Status','Created At'];
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
