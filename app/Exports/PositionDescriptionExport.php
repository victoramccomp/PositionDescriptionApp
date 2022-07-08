<?php

namespace App\Exports;

use App\PositionDescription;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class PositionDescriptionExport implements FromView
{
    use Exportable;
    
    protected $positionDescriptionId;
    
    public function __construct(int $positionDescriptionId)
    {
        $this->positionDescriptionId = $positionDescriptionId;
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
        $positionDescriptions = PositionDescription::with('position')
            ->with('gradeCourses.grade')
            ->with('gradeCourses.area')
            ->with('languages')
            ->with('competences')
            ->with('competences.competenceType')
            ->with('competenceLevel')
            ->with('targets')
            ->with('activities')
            ->findOrfail($this->positionDescriptionId);

        return view('positionDescription.readPositionDescription', [
            'positionDescriptions' => $positionDescriptions
        ]);
    }
}
