<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
{
    public function showimage($imageName)
    {
        $file = storage_path('app/private/image/' . $imageName);
        $bookData = Books::where('image', $imageName)->first();
        if ($bookData->userId == Auth::user()->id || Auth::user()->role == 'admin')
        {        
            return response()->file($file);
        }else{
            return redirect()->route('home');
        }
    }
    public function showpdf($pdfName)
    {
        $file = storage_path('app/private/pdf/' . $pdfName);
        $bookData = Books::where('pdf', $pdfName)->first();
        if ($bookData->userId == Auth::user()->id || Auth::user()->role == 'admin')
        {        
            return response()->file($file);
        }else{
            return redirect()->route('home');
        }
    }
}
