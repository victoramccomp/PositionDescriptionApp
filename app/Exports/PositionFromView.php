<?php

namespace App\Exports;

use App\Position;
use Maatwebsite\Excel\Concerns\FromCollection;

class PositionFromView implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Position::all();
    }
}
