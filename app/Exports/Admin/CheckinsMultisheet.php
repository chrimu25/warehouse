<?php

namespace App\Exports\Admin;
use App\Exports\Admin\Checkins;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CheckinsMultisheet implements WithMultipleSheets
{
    private $year;

    public function __construct(int $year)
    {
        $this->year = $year;
    }

    public function sheets(): array
    {
        $sheets = [];

        for($month=1;$month<=12;$month++){
            $sheets[] = new Checkins($this->year,$month);
        }

        return $sheets;
    }
}
