<?php

namespace App\Http\Controllers;
use App\Models\Books;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $booksData = Books::where('userId', Auth::user()->id)->get();
        return view('welcome', [
            'bookData' => $booksData
        ]);
    }

}
