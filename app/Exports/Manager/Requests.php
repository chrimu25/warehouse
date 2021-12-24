<?php

namespace App\Exports\Manager;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class Requests implements FromQuery, WithMapping,WithHeadings,WithCustomStartCell,ShouldAutoSize
{
    public function query()
    {
        return Product::with('owner','category','unity','incharge1','item','slot')
        ->where('status', 'Pending')
        ->where('warehouse_id',Auth::user()->warehouse->id)
        ->where('out',0)
        ->whereMonth('created_at',date('m'))->whereYear('created_at',date('Y'));
    }

    public function map($product): array
    {
        return [
            $product->item->name,
            $product->quantity,
            $product->unity->name,
            $product->owner->name,
            $product->slot->name,
            $product->created_at->format('Y-m-d'),
            $product->until->format('Y-m-d'),
        ];
    }

    public function headings(): array
    {
        return ['Item','Quantity','Unity',"Owner",'Slot', 'Created At', 'Until'];
    }

    public function startCell(): string
    {
        return "B6";
    }
}
