<?php

namespace App\Exports\Admin;

use App\Models\Product;
use DateTime;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class Store implements FromQuery, WithMapping,WithHeadings,WithCustomStartCell, WithTitle,ShouldAutoSize
{
    private $year,$month;

    public function __construct(int $year, int $month)
    {
        $this->year = $year;
        $this->month = $month;
    }
    public function query()
    {
        return Product::with('owner','category','unity','incharge1','item','warehouse','slot')
        ->whereMonth('created_at',$this->month)->whereYear('created_at',$this->year);
    }

    public function map($product): array
    {
        return [
            $product->owner?$product->owner->name:'',
            $product->item?$product->item->name:'',
            $product->quantity,
            $product->unity?$product->unity->name:'',
            $product->warehouse?$product->warehouse->name:'',
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

    public function title(): string
    {
        return DateTime::createFromFormat('!m',$this->month)->format('F');
    }
}
