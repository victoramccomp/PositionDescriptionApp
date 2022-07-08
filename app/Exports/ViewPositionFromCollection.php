<?php

namespace App\Exports;

use App\ViewPosition;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ViewPositionFromCollection implements FromCollection, WithHeadings, WithTitle, WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ViewPosition::all();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Posições';
    }

    public function headings(): array
    {
        return [
            'id',
            'código',
            'posição',
            'grupo',
            'área',
            'grade salarial',
        ];
    }
}
