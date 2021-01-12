<div class="recursive-block">
    @if(!($nivelJerarquico->concreto() instanceof \App\Models\Grupo))
        <a
            class="no-style"
            href="#"
            role="button"
            onclick="toggleCollapse({{ $nivelJerarquico->componente_id }})"
        >
            <div class="toggle inline-toggle" id="toggle{{ $nivelJerarquico->componente_id }}">
                {{ $nivelJerarquico->nombre }} <img src="{{ asset('svg/triangle-right.svg') }}" alt="">
            </div>
            @isset($showEditMembers)
                <a href="{{ route('jerarquia.miembros',$nivelJerarquico)}} ">
                    Editar miembros
                </a>
            @endisset
        </a>
    @else
        <div class="inline-toggle">
            {{ $nivelJerarquico->nombre . ": "}}
            @isset($showEditMembers)
                <a href="{{ route('jerarquia.miembros',$nivelJerarquico)}} ">
                    Editar miembros
                </a>
            @endisset
            {{-- </a> --}}
        </div>
    @endif
    @if($canErase)
        <form class="d-inline" method="post" action="{{ route('jerarquia.destroy', $nivelJerarquico) }}">
            @csrf
            @method('delete')
            <input type="submit" value="Eliminar" class="bg-transparent border-0 btn-link text-danger">
        </form>
    @endif
    <div class="collapse recursive-content" id="collapse{{ $nivelJerarquico->componente_id }}">
        @foreach ($nivelJerarquico->niveles()->get() as $hijo)
            @include('admin.jerarquia.__recursive-block', ['nivelJerarquico' => $hijo->nivelJerarquico()->first(), 'groupsOnly' => $hijo->concreto()->nivel >= 3, 'showEditMembers' => true, 'canErase' => true])
        @endforeach

        @include('admin.jerarquia.__add-new', compact('nivelJerarquico', 'groupsOnly'))
    </div>
</div>
