<?php

namespace App\Exports;

use App\ViewPositionDescriptionLanguage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ViewPositionDescriptionLanguageFromCollection implements FromCollection, WithHeadings, WithTitle, WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ViewPositionDescriptionLanguage::all();
    }
    
    /**
     * @return string
     */
    public function title(): string
    {
        return 'Idioma';
    }

    public function headings(): array
    {
        return [ 
            'dep_id',
            'code',
            'position',
            'interviewed',
            'language_requirement',
            'language_level',
            'language_skill',
            'language_id',
            'language_description',
        ];
    }
}
