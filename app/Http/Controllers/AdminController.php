<?php

namespace App\Http\Controllers;
use App\Models\Books;
use App\Models\Categories;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $userData = User::all();
        return view('admin.index', [
            'userData' => $userData
        ]);
    }    

    public function userBooks($id)
    {
        $count = Books::where('userId', $id)->count();
        $bookData = Books::where('userid', $id)->get(); 
        return view('admin.userbook', [
            'bookCount' => $count,
            'bookData' => $bookData
        ]);
    }

    public function userCategory($id)
    {
        $role = Auth::user()->role;
        
        $count = Categories::where('userId', $id)->count();
        
        $userCategoryData = Categories::where('userId', $id)->get();
        
        return view('admin.usercategory', [
            'categoryCount' => $count,
            'role' => $role,
            'userCategoryData' => $userCategoryData
        ]);
    }
    

    public function userSpecifyCategory($userId,$category)
    {
        $categoryid = Categories::where('name', $category)
        ->where('userId', $userId)
        ->pluck('id')
        ->first(); 

        $count = Categories::where('userId', $userId)->count();
        $userCategoryData = Books::where('userId', $userId)
        ->where('category_id', $categoryid)
        ->get();
        return view('welcome', [
            'bookCount' => $count,
            'bookData' => $userCategoryData
        ]);
    }

    
    
    
}
