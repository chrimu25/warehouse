<?php

namespace App\Exports\Manager;

use App\Models\Transfer;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class Outgoings implements FromQuery, WithMapping,WithHeadings,WithCustomStartCell,ShouldAutoSize
{
    public function query()
    {
        return Transfer::with('owner1','toWarehouse','unity','product')
        ->where('from',Auth::user()->warehouse->id)
        ->whereMonth('created_at',date('m'))->whereYear('created_at',date('Y'));
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
            $transfer->approved?'Approved':'Pending',
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
}
