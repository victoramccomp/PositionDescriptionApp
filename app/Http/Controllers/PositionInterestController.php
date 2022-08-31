<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\PositionInterest;
use App\PositionDescription;
use App\ConfigPositionInterest;
use App\Http\Requests\PositionInterestFormRequest;
use App\ViewPositionInterest;
use App\Exports\PositionInterestExcel;
use Maatwebsite\Excel\Facades\Excel;

class PositionInterestController extends Controller
{
    public function index( Request $request ) 
    {
        $positionInterests = PositionInterest::with('positionDescription.position')
            ->orderBy('created_at', 'DESC')
            ->paginate(20);

        $message = $request->session()->get('message');

        return view( 'positionInterest.listPositionInterest', [ 'positionInterests' => $positionInterests, 'message' => $message ] );
    }

    public function create( int $positionDescriptionId) 
    {
        $configPositionInterest = ConfigPositionInterest::first();
        $positionDescription = PositionDescription::with('position')->findOrFail($positionDescriptionId);

        return view( 'positionInterest.createPositionInterest', 
        [ 
            'positionDescription' => $positionDescription,
            'configPositionInterest' => $configPositionInterest
        ]);
    }

    public function store( PositionInterestFormRequest $request )
    {
        $positionInterest = new PositionInterest();
        $positionInterest->name = $request->name;
        $positionInterest->document_type = $request->documentType;
        $positionInterest->dep_id = $request->depId;

        if ( $request->documentType === 'cpf' )
            $positionInterest->document_info = $request->cpf;
        elseif ( $request->documentType === 'email' )
            $positionInterest->document_info = $request->email;
        elseif ( $request->documentType === 'registration' )
            $positionInterest->document_info = $request->registration;

        $positionInterest->save();

        $request->session()->flash('message', "$positionInterest->name cadastrado com sucesso!");

        return redirect()->route('reportListPositionDescription');
    }

    public function exportXLSX()
    {
        $positionInterest = ViewPositionInterest::all();

        return (new PositionInterestExcel)->download('demonstraçãoDeInteresse.xlsx', \Maatwebsite\Excel\Excel::XLSX);
    }
}
