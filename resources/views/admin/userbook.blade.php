<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CMS Backend Assignment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
  </head>
  <body>
    @include('layouts.navbar')
    @if($bookCount == 0)
    <center>
      <p style="padding-top: 40vh;">"Belum ada buku yang ditambahkan."</p>
  </center>
    @else
    <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">id</th>
              <th scope="col">Nama</th>
              <th scope="col">Kategori</th>
              <th scope="col">Deskripsi</th>
              <th scope="col">Jumlah</th>
              <th scope="col">Cover</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($bookData as $book)

            <tr>
                <td>{{ $book->id }}</td>
                <td>{{ $book->title }}</td>
                <td>{{ $book->category->name }}</td>
                <td style="max-width: 500px;">{{ $book->description }}</td>
                <td>{{ $book->quantity }}</td>
                <td>
                  <img src="{{ route('img.show', ['imageName' => $book->image]) }}" alt="Book Image" style="max-width: 150px;">
                </td>
                
                </td>
                <td><a class="btn btn-dark" href="{{ route('pdf.show', ['pdfName' => $book->pdf]) }}">pdf</a>

                <a class="btn btn-primary" href="{{ route('book.edit', ['bookId' => $book->id]) }}">Edit</a>

                
<!-- Button trigger modal -->
<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $book->id }}">
    Delete
  </button>
  
  <!-- Modal -->
  <div class="modal fade" id="exampleModal{{ $book->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Buku</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Data Kategori Buku {{ $book->title }} akan dihapus, anda yakin ?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <form method="POST" action="{{ route('book.delete') }}">
            @csrf
            <input type="hidden" name="id"
                value="{{ $book->id }}">
            <button type="submit" class="btn btn-danger">Delete</button>
        </form>
        </div>
      </div>
    </div>
  </div>
                </td>
              </tr>
@endforeach

          </tbody>
        </table>
      </div>
      @endif
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</html>



