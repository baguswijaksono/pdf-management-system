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
    @if($categoryCount == 0)

    <center>
      <p style="padding-top: 40vh;">"Belum ada kategori yang ditambahkan."</p>
  </center>



    @else
    <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">id</th>
              <th scope="col">Nama</th>
              <th scope="col">Total Buku</th>
              <th scope="col">Semua Buku</th>
              <th scope="col">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($userCategoryData as $category)
            @php
            $count = App\Models\Books::where('userId',  $category->userId )
            ->where('category_id', $category->id)
            ->count();
          
            @endphp
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $count }}</td>
                <td><a class="btn btn-dark" href="{{ route('user.category.specify', ['userId'=>$category->userId,'category' => $category->name]) }}">Details</a></td>
                <td><a class="btn btn-primary" href="{{ route('category.edit', ['categoryId' => $category->id]) }}">Edit</a>

                
<!-- Button trigger modal -->
<button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $category->id }}">
    Delete
  </button>
  
  <!-- Modal -->
  <div class="modal fade" id="exampleModal{{ $category->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Data Kategori Buku {{ $category->name }} akan dihapus, anda yakin ?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <form method="POST" action="{{ route('category.delete') }}">
            @csrf
            <input type="hidden" name="id"
                value="{{ $category->id }}">
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



