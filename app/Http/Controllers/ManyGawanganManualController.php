<?php

namespace App\Http\Controllers;

use App\Exports\ManyGawanganManualsExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ManyGawanganManualController extends Controller
{
    public function export()
    {
        return Excel::download(new ManyGawanganManualsExport, 'Many-gawngan-Manual-Export.xlsx');
    }
}
