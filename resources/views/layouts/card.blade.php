<style>
    .image-container {
        position: relative;
        display: inline-block;
    }

    .overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .overlay-text {
        color: white;
        font-weight: bold;
        text-align: center;
        position: absolute;
        top: 50%;
        left: 50%;
        font-size: 12px;
        transform: translate(-50%, -50%);
    }

    .image-container:hover .overlay {
        opacity: 1;
    }
</style>

<div style="padding-left: 15px; padding-top: 15px; display: inline-block;">
    <div class="card" style=" width: 175px;">
        <a href="{{ route('book.details', ['id' => $book->id]) }}">
            <div class="image-container">
                <img src=" {{ route('img.show', ['imageName' => $image]) }}
                    " class="rounded"
                    alt="" style="height : 250px; width: 175px;">
                <div class="overlay">
                    <p class="overlay-text">{{ $title }}</p>
                </div>
            </div>
        </a>
        <div class="card-body">
            <h6
                style="display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 1; overflow: hidden; text-overflow: ellipsis;">
                {{ $title }}</h6>
            <p class="card-text">{{ $category }}</p>
        </div>

    </div>
</div>
