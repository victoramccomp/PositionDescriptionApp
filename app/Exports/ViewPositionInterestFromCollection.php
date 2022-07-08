<?php

namespace App\Exports;

use App\ViewPositionInterest;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ViewPositionInterestFromCollection implements FromCollection, WithHeadings, WithTitle, WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ViewPositionInterest::all();
    }
    
    /**
     * @return string
     */
    public function title(): string
    {
        return 'Demonstração de Interesse';
    }

    public function headings(): array
    {
        return [ 
            'dep_id',
            'code',
            'position',
            'name',
            'document_type',
            'document_info',
            'date',
        ];
    }
}