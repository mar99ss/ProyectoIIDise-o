<a href="{{ route($route) }}" class="li-link">
    <li class="{{ \App\Helpers\AppHelper::setActive("$route_active") }}">
        <img src="{{ asset("svg/$svg.svg") }}" alt="" class="icon">
        {{ $title }}
    </li>
</a>
