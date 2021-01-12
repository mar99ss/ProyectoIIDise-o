<p>
    @isset($link)
        <a href="{{ $link }}">{{ preg_replace('#^https?://#', '', $link) }}</a>
    @else
        <b>{{ $title }}:</b> {{ $text }}
    @endif
</p>
