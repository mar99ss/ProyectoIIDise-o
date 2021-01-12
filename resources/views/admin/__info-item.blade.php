<div class=" text-item overflow-hidden  ">
    <div class="row justify-content-center pt-3 px-3">
        <div class="col-md-6 my-2 pr-5">
            <h4 class="nunito-bold my-2 py-2">{{ $number }}</h4>

            <p>{{ $description }}</p>
        </div>
        <div class="col-md-6 my-2 px-5 pt-3">
            <img src="{{ asset("img/{$pngImage}.png") }}" height="50" width="50" alt="{{ $pngImage }}">
        </div>
    </div>
</div>
