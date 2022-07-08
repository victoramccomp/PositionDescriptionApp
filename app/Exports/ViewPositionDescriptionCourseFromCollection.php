<?php

namespace App\Exports;

use App\ViewPositionDescriptionCourse;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ViewPositionDescriptionCourseFromCollection implements FromCollection, WithHeadings, WithTitle, WithStrictNullComparison
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return ViewPositionDescriptionCourse::all();
    }
    
    /**
     * @return string
     */
    public function title(): string
    {
        return 'Formação';
    }

    public function headings(): array
    {
        return [ 
            'dep_id',
            'code',
            'position',
            'interviewed',
            'course_requirement',
            'course_status',
            'course_id',
            'course_area_id',
            'course_grade_id',
            'course_description',
            'grade_description',
            'area_description',
        ];
    }
}
