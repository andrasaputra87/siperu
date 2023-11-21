<?php

namespace App\Exports;

use App\Exports\BMExport;
use App\Exports\BMPerMonthSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MultipleBMExport implements WithMultipleSheets
{
    use Exportable;

    protected $year;
    
    public function __construct(int $year)
    {
        $this->year = $year;
    }

    public function sheets(): array
    {
        $sheets = [];

        // Add your sheets and their data here
        $sheets[] = new BMExport;
        // $sheets[] = new BAAKExport;

        for ($month = 1; $month <= 12; $month++) {
            $sheets[] = new BMPerMonthSheet($this->year, $month);
        }

        return $sheets;

    }
}
