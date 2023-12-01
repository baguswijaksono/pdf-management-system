<!doctype html>
    <html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CMS Backend Assignment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
</head>

<style>
    form {
        width: 55vw;
        /* panjang form, 1/3 lebar browser */
        height: 25vh;
        /* tinggi form, 1/4 tinggi browser */
        position: absolute;
        /* membuat form menjadi posisi absolut */
        top: 30%;
        /* membuat form berada di tengah vertikal */
        left: 50%;
        /* membuat form berada di tengah horizontal */
        transform: translate(-50%, -50%);
        /* membuat form berada di tengah pusat */
    }

    .disabled-input {
        pointer-events: none;
        opacity: 0.6;
    }
</style>

<body>
    @include('layouts.navbar')
    @if ($errors->any())
    <div class="p-4">
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
            {{ $error }}
            @endforeach
    </div>
    </div>
    @endif
    

    <form class="row g-3 needs-validation" novalidate action="{{route('book.add.save')}}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="col-md-12">
            <label for="animeId" class="form-label">Judul Buku</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="col-md-12">
            <label for="category" class="form-label">Kategori Buku</label>
            <select id="category" name="category" class="form-select" aria-label="Default select example">
                <option selected>Open this select menu</option>
                @foreach($userCategoryData as $category)
                <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
              </select>
        </div>

        <div class="col">
            <div class="form-floating">
                <textarea class="form-control" placeholder="Add synopsis here" name="description" id="description"></textarea>
                <label for="synopsis">Deskripsi</label>
            </div>
        </div>

        <div class="col-md-12">
            <label for="quantity" class="form-label">Jumlah</label>
            <input type="number" class="form-control" id="quantity" name="quantity" value="" required>
        </div>

        <div class="col-md-12">
            <label for="image" class="form-label">Image</label>
            <input class="form-control" type="file" name="image" accept=".jpeg, .jpg, .png">
        </div>
        

        <div class="col-md-12">
            <label for="pdf" class="form-label">PDF</label>
            <input type="file" class="form-control" id="pdf" name="pdf" accept=".pdf">
        </div>
        
        
        <div class="col-12">
            <button class="btn btn-dark" type="submit">Save Changes</button>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>
</body>

</html>