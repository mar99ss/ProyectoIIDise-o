@if(!$groupsOnly)
    <form action="{{ route('jerarquia.crearNivelJerarquico', $nivelJerarquico) }}"
          class="d-flex align-items-center"
          method="post"
    >
        @csrf
        @method('PUT')
        <input type="text" class="input-shadow" name="nombre" id="" placeholder="Nuevo nombre">
        <button type="submit" class="ml-4 btn btn-primary btn-green-moon">Crear nuevo</button>
    </form>
@else
    <button type="submit" class="btn btn-primary btn-green-moon" onclick="showModalNuevoGrupo({{ $nivelJerarquico }})">Crear nuevo</button>
@endif
