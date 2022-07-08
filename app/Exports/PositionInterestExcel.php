<?php

namespace App\Exports;

use App\PositionInterest;
// Views
use App\ViewPositionDescription;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PositionInterestExcel implements WithMultipleSheets
{
    use Exportable;

    public function sheets(): array
    {
        $sheets = [ 
            new ViewPositionInterestFromCollection(),
         ];
     
        return $sheets;
    }
}
