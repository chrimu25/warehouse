<?php

namespace App\Exports\Admin;

use App\Exports\Admin\Checkouts;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CheckoutsMultisheet implements WithMultipleSheets
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
            $sheets[] = new Checkouts($this->year,$month);
        }

        return $sheets;
    }
}
