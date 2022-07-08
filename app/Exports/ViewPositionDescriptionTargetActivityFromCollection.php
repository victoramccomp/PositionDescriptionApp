<?php

namespace App\Exports;

use App\ViewPositionDescriptionTargetActivity;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ViewPositionDescriptionTargetActivityFromCollection implements FromCollection, WithHeadings, WithTitle, WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ViewPositionDescriptionTargetActivity::all();
    }
    
    /**
     * @return string
     */
    public function title(): string
    {
        return 'Objetivos e Atividades';
    }

    public function headings(): array
    {
        return [ 
            'dep_id',
            'code',
            'position',
            'interviewed',
            'main_target_id',
            'main_target_description',
            'main_activity_id',
            'main_activity_description',
            'classification',
        ];
    }
}
