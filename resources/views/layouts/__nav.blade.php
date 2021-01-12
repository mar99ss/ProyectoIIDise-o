<ul>
    @include('layouts.__nav_item', ['route_active' => 'admin', 'route' => 'admin', 'svg' => 'home', 'title' => 'Inicio'])
    @include('layouts.__nav_item', ['route_active' => 'miembros.*', 'route' => 'miembros.index', 'svg' => 'members', 'title' => 'Miembros'])
    @include('layouts.__nav_item', ['route_active' => 'jerarquia.*', 'route' => 'jerarquia.index', 'svg' => 'hierarchy', 'title' => 'Jerarquía'])
</ul>
