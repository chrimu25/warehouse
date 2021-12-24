<?php

namespace App\Exports\Admin;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MonthlyStore implements FromQuery, WithMapping,WithHeadings,WithCustomStartCell,ShouldAutoSize
{
    public function query()
    {
        return Product::with('owner','category','unity','incharge1','item','warehouse','slot')
        ->whereMonth('created_at',date('m'))->whereYear('created_at',date('Y'));
    }

    public function map($product): array
    {
        return [
            $product->owner?$product->owner->name:'',
            $product->item?$product->item->name:'',
            $product->quantity,
            $product->unity?$product->unity->name:'',
            $product->warehouse->name,
            $product->slot?$product->slot->name:'',
            $product->status,
            $product->created_at->format('Y-m-d'),
            $product->until->format('Y-m-d'),
        ];
    }

    public function headings(): array
    {
        return ['Client','Item','Quantity','Unity','Warehouse','Slot','Status','From','Until'];
    }

    public function startCell(): string
    {
        return "B3";
    }
}
