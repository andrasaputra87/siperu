<?php

namespace App\Exports;

use App\Exports\BAAKExport;
use App\Exports\BAAKPerMonthSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MultipleBAAKExport implements WithMultipleSheets
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
        $sheets[] = new BAAKExport;
        // $sheets[] = new BAAKExport;

        for ($month = 1; $month <= 12; $month++) {
            $sheets[] = new BAAKPerMonthSheet($this->year, $month);
        }

        return $sheets;

    }
}
