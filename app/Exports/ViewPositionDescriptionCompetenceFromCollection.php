<?php

namespace App\Exports;

use App\ViewPositionDescriptionCompetence;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ViewPositionDescriptionCompetenceFromCollection implements FromCollection, WithHeadings, WithTitle, WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ViewPositionDescriptionCompetence::all();
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return 'Requisitos Específicos';
    }

    public function headings(): array
    {
        return [ 
            'dep_id',
            'code',
            'position',
            'interviewed',
            'competence_level',
            'competence_requirement',
            'competence_id',
            'competence_description',
            'competence_level_id',
            'competence_level_description',
            'competence_level_type_id',
            'competence_type_id',
            'competence_type_description',
        ];
    }
}
