<?php

namespace App\Exports;

use App\PositionDescription;
// Views
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PositionExcel implements WithMultipleSheets
{
    use Exportable;

    public function sheets(): array
    {
        $sheets = [
            new ViewPositionFromCollection(),
         ];

        return $sheets;
    }
}
