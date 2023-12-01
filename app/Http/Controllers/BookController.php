<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\Categories;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    public function index()
    {
        $count = Books::where('userId', Auth::user()->id)->count();
        $booksData = Books::where('userId', Auth::user()->id)->get();
        return view('user.books.index', [
            'bookCount' => $count,
            'bookData' => $booksData
        ]);
    }

    public function bookAdd()
    {
        $userCategoryData = Categories::where('userId', Auth::user()->id)->get();
        return view('user.books.add', [
            'userCategoryData' => $userCategoryData
        ]);
    }

    public function bookAddSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'category' => 'required|integer|min:1',
            'description' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'image' => 'image|mimes:jpeg,png,jpg',
            'pdf' => 'file|mimes:pdf|max:10000', // Validate max file size: 10MB
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $bookData = [
                'userId' => Auth::user()->id,
                'title' => $request->input('title'),
                'category_id' => $request->input('category'),
                'description' => $request->input('description'),
                'quantity' => $request->input('quantity'),
            ];

            if ($request->hasFile('image')) {
                $imageName = time() . Auth::user()->id . "." . $request->file('image')->extension();
                Storage::disk('image')->put($imageName, file_get_contents($request->file('image')->getRealPath()));
                $bookData['image'] = $imageName;
            }else{
                return redirect()->back()->withErrors(['error' => 'Anda belum mengupload gambar.']);
            }

            if ($request->hasFile('pdf')) {
                $pdfName = time() . Auth::user()->id . "." . $request->file('pdf')->extension();
                Storage::disk('pdf')->put($pdfName, file_get_contents($request->file('pdf')->getRealPath()));
                $bookData['pdf'] = $pdfName;
            }else{
                return redirect()->back()->withErrors(['error' => 'Anda belum mengupload pdf.']);
            }
            $book = Books::create($bookData);
            return redirect()->route('book');
        }
    }


    public function bookDelete(Request $request)
    {
        $book = Books::find($request->input('id'));
        if ($book) {
            if ($book->userId === Auth::user()->id || Auth::user()->role == 'admin') {
                if ($book->image) {
                    Storage::disk('image')->delete($book->image);
                }

                if ($book->pdf) {
                    Storage::disk('pdf')->delete($book->pdf);
                }

                $book->delete();
                if(Auth::user()->role == 'admin'){
                    return redirect()->route('user.books', ['userId' => $book->userId])->with('success', 'Data Buku telah berhasil dihapus sepenuhnya!');
                }else{
                return redirect()->route('book')->with('success', 'Data Buku telah berhasil dihapus sepenuhnya!');
                }
            } else {
                return redirect()->route('home');
            }
        } else {
            return redirect()->back()->withErrors(['error' => 'Buku tidak ditemukan.']);
        }
    }

    public function bookEdit($bookId)
    {
        $data = ['bookId' => $bookId];
        $rules = [
            'bookId' => 'required|integer',
        ];
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $book = Books::find($bookId);
            if ($book) {
                if ($book->userId === Auth::user()->id || Auth::user()->role == 'admin') {
                    $userCategoryData = Categories::where('userId', Auth::user()->id)->get();
                    return view('user.books.edit', [
                        'data' => $book,
                        'userCategoryData' => $userCategoryData
                    ]);
                } else {
                    return redirect()->route('home');
                }
            } else {
                return redirect()->back()->withErrors(['error' => 'Category not found.']);
            }

        }
    }

    public function bookUpdateSave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'description' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $bookData = [
                'title' => $request->input('title'),
                'category' => $request->input('category'),
                'description' => $request->input('description'),
                'quantity' => $request->input('quantity'),
            ];
            $old = Books::find($request->input('id'));
            if ($request->hasFile('image')) {
                Storage::disk('image')->delete($old->image);
                $imageName = time() . Auth::user()->id . "." . $request->file('image')->extension();
                Storage::disk('image')->put($imageName, file_get_contents($request->file('image')->getRealPath()));
                $bookData['image'] = $imageName;
            }
            if ($request->hasFile('pdf')) {
                Storage::disk('pdf')->delete($old->pdf);
                $pdfName = time() . Auth::user()->id . "." . $request->file('pdf')->extension();
                Storage::disk('pdf')->put($pdfName, file_get_contents($request->file('pdf')->getRealPath()));
                $bookData['pdf'] = $pdfName;
            }
            $book = Books::find($request->input('id'));

            if (!$book) {
                return redirect()->back()->with('error', 'Book not found!');
            }
            $book->update($bookData);
            if (Auth::user()->role == 'admin') {
                return redirect()->route('user.books', ['userId' => $old->userId]);
            } else {
                return redirect()->route('book')->with('success', 'Book updated successfully!');
            }

            
        }
    }

    public function bookDetails($id)
    {
        $booksData = Books::where('id', $id)->first();

        if ($booksData->userId == Auth::user()->id || Auth::user()->role == 'admin') {
            return view('user.books.details', [
                'bookData' => $booksData
            ]);
        } else {
            return redirect()->route('home');
        }
    }

    public function specifyCategory($category)
    {
        $categoryid = Categories::where('name', $category)
            ->where('userId', Auth::user()->id)
            ->pluck('id')
            ->first(); 
    
        $count = Books::where('id', $categoryid)
            ->where('userId', Auth::user()->id)
            ->count();
    
        $booksData = Books::where('category_id', $categoryid)
            ->where('userId', Auth::user()->id)
            ->get();
    
        return view('welcome', [
            'bookCount' => $count,
            'bookData' => $booksData
        ]);
    }
    


}