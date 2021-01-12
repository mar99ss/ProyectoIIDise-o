<div class="text-item row px-2 justify-content-center my-2 overflow-hidden">
    <div class="d-flex flex-column col-md-6 col-sm-12">
        <span class="nunito-bold my-2">{{ $title }}</span>
        <p>{{ $text }}</p>
    </div>
    <img src="{{ asset("svg/{$svgImage}.svg") }}" alt="{{ $svgImage }}">
</div>
