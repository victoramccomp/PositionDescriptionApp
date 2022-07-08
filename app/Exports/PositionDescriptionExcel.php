<?php

namespace App\Exports;

use App\PositionDescription;
// Views
use App\ViewPositionDescription;
use App\ViewPositionDescriptionCourse;
use App\ViewPositionDescriptionCompetence;
use App\ViewPositionDescriptionLanguage;
use App\ViewPositionDescriptionTargetActivity;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PositionDescriptionExcel implements WithMultipleSheets
{
    use Exportable;

    public function sheets(): array
    {
        $sheets = [ 
            new ViewPositionDescriptionFromCollection(),
            new ViewPositionDescriptionCourseFromCollection(),
            new ViewPositionDescriptionCompetenceFromCollection(),
            new ViewPositionDescriptionLanguageFromCollection(),
            new ViewPositionDescriptionTargetActivityFromCollection(),
         ];
     
        return $sheets;
    }
}
