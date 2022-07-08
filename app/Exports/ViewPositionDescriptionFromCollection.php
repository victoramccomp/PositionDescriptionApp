<?php

namespace App\Exports;

use App\ViewPositionDescription;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ViewPositionDescriptionFromCollection implements FromCollection, WithHeadings, WithTitle, WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ViewPositionDescription::all();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Descrição de Posição';
    }

    public function headings(): array
    {
        return [
            'dep_id',
            'code',
            'salary_grade',
            'interviewed',
            'position_id',
            'position',
            'position_group',
            'area',
            'mission',
            'experience_time',
            'leadership_time',
            'allowhomeoffice',
            'created_at',
            'updated_at',
            'interviewer_comments',
            'restrictions',
            'is_activated'
        ];
    }
}
