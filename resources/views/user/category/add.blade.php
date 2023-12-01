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
        height: 2vh;
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

    <form class="row g-3 needs-validation" novalidate action="{{route('category.add.save')}}" method="POST">
        @csrf
        <div class="col-md-12">
            <label for="name" class="form-label">Nama Kategory Buku</label>
            <input type="text" class="form-control" id="name" name="name" value="" required>
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