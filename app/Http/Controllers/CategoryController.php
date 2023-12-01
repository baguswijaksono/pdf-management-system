<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\Categories;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Worksheet\Column;

class CategoryController extends Controller
{
    public function index()
    {
        $count = Categories::where('userId', Auth::user()->id)->count();
        $userCategoryData = Categories::where('userId', Auth::user()->id)->get();
        return view('user.category.index', [
            'role'=> Auth::user()->role,
            'categoryCount'=>$count,
            'userCategoryData' => $userCategoryData
        ]);
    }

    public function categoryAddSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);

        $categoryCount = Categories::where('name', $request->input('name'))->where('userId', Auth::user()->id)->count();
        if($categoryCount <= 0){
            $category = new Categories;
            $category->userId = Auth::user()->id;
            $category->fill($validator->validated());
            $category->save();
            return redirect()->route('category')->with('success', 'Kategori telah berhasil ditambahkan!');
        }else{
            return redirect()->back()->withErrors(['name' => 'Nama kategori sudah ada!'])->withInput();
        }

    }

    public function categoryEdit($categoryId)
    {
        $data = ['CategoryId' => $categoryId];
        $rules = [
            'CategoryId' => 'required|integer',
        ];
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $category = Categories::find($categoryId);

            if ($category) {
                if ($category->userId === Auth::user()->id || Auth::user()->role == 'admin') {
                    return view('user.category.edit', [
                        'data' => $category
                    ]);
                } else {
                    return redirect()->route('home');
                }
            } else {
                return redirect()->back()->withErrors(['error' => 'Kategori tidak ditemukan.']);
            }

        }
    }


    public function categoryUpdateSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'id' => 'required|integer',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $category = Categories::find($request->input('id'));
            
            if (!$category) {
                return redirect()->back()->withErrors(['error' => 'Category not found.']);
            }
            
            if ($category->userId === Auth::user()->id || Auth::user()->role === 'admin') {
                // Update the category name
                $category->name = $request->input('name');
                $category->updated_at = Carbon::now()->format('Y-m-d H:i:s');
                $category->save();
    
                // Update related books' category names
                $books = Books::where('category_id',  $request->input('id'))->get();
                foreach ($books as $book) {
                    $book->update(['category' => $request->input('name')]);
                }
    
                return redirect()->route('category')->with('success', 'Kategori Telah berhasil Update!');
            } else {
                return redirect()->route('home');
            }
        }
    }

    public function categoryDelete(Request $request)
    {
        $category = Categories::find($request->input('id'));
        $books = Books::where('category_id', $category->name)->get();
        if ($category) {
            if ($category->userId === Auth::user()->id || Auth::user()->role == 'admin') {
                $books->each->delete();
                $category->delete();
                return redirect()->route('category')->with('success', 'Kategori Telah berhasil dihapus!');
            } else {
                return redirect()->route('home');
            }
        } else {
            return redirect()->back()->withErrors(['error' => 'Kategori tidak ditemukan.']);
        }    

    }

    

    


}