<?php

namespace App\Exports;

use App\Models\Books;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BooksExport implements FromCollection , WithHeadings
{
    public function headings(): array
    {
        // Define the header row here
        return [
            'id',
            'Judul Buku',
            'Kategori',
            'Deskripsi',
            'Jumlah',
            'Url Gambar Cover',
            'Url Pdf',
        ];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        if(Auth::user()->role == 'admin'){
            $buku = Books::select('books.id', 'books.title', 'categories.name as category_name', 'books.description', 'books.quantity', 'books.image', 'books.pdf')
            ->join('categories', 'books.category_id', '=', 'categories.id')
            ->get();
        }else{
            $buku = Books::select('books.id', 'books.title', 'categories.name as category_name', 'books.description', 'books.quantity', 'books.image', 'books.pdf')
            ->join('categories', 'books.category_id', '=', 'categories.id')
            ->where('books.userId', Auth::user()->id)
            ->get();
        }
        foreach ($buku as $book) {
            $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
            $host = $_SERVER['HTTP_HOST'];
            //image
            $currentURL = $protocol . $host . '/private/img';
            $book->image = $currentURL . '/' . $book->image;
            //pdf
            $currentURL = $protocol . $host . '/private/pdf';
            $book->pdf = $currentURL . '/' . $book->pdf;
        }
        return $buku;
    }
    


}
