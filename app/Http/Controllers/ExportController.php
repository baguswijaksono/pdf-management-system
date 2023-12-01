<?php

namespace App\Http\Controllers;

use App\Exports\BooksExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{

    public function exportToExcel()
    {
        $dateTimeNow = date('Ymd_His'); // format: YYYYmmdd_HHiiSS
        $filename = 'data_buku_' . $dateTimeNow . '.xlsx';
        return Excel::download(new BooksExport, $filename);
    }
}
