@extends('layouts.horizontal-layout')

@section('links')
    <link rel="stylesheet" href="{{ mix('css/edit-miembros.css') }}">
@endsection

@section('content')
<form  action="{{ route('jerarquia.miembros', $nivelJerarquico) }}">
    <div class="row mx-4  mb-2 px-2 d-flex ">
        <div class="col-md-5 col-sm-12 d-flex my-3 mr-3">
            <div class="row mx-0">
                    <label class="mr-5">Filtrar por:</label>
                    <input class="input-shadow w-100 mr-2 mb-3" type="text" class="form-control inner-shadow "
                           id="filterby" name="valor" placeholder="Valor a buscar" value="{{ isset($filtro) ? $valor : '' }}">

                    <div class="col-md-12 col-sm-12  mb-3">
                        <input class="" type="radio" name="filtroMiembros" value="identificacion" {{ isset($filtro) ? $filtro == 'identificacion' ? 'checked' : '' : 'checked' }}>
                        <label>Identificación</label>
                        <input class="ml-3" type="radio" name="filtroMiembros" value="nombreCompleto" {{ isset($filtro) ? $filtro == 'nombreCompleto' ? 'checked' : '' : '' }}>
                        <label for="name">Nombre</label>
                    </div>
                    
            </div>
        </div>

        <div class="col-md-3 ml-5">
            <div class="row ">
                <div class="custom-control custom-checkbox">
                    <div class="col-md-12 ml-5 my-2 px-0">
                            <p class="nunito-bold">Mostrar roles</p>
                            @foreach($rolesDisponibles as $rol)
                                <div class="col-md-12 ml-5 my-2 px-0">
                                    <input type="checkbox"
                                           id="chk{{$rol}}"
                                           class="custom-control-input"
                                           name="filtro[]"
                                           value="{{ $rol }}"
                                        {{ $rolesFiltrados != null ? in_array($rol, $rolesFiltrados) ? 'checked' : '' : 'checked' }}
                                    >
                                    <label class="custom-control-label" for="chk{{$rol}}">{{ ucfirst($rol) }}</label>
                                </div>
                            @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md mx-4">
            <div class="row d-flex justify-content-end ml-0 pl-0">
                <img src="{{ session('movimiento')->logo }}" alt="Logo {{ session('movimiento')->nombre }}"
                     class="movement-logo">
                <span class="d-md-none d-sm-block space-separator"></span>
            </div>
        </div>

        <div class="col-md-7 mx-4">
            <button class="btn btn-primary btn-block shadow btn-green-moon " type="submit">Buscar</button>
        </div>
    </div>
</form>

    <h4 class="pl-5 pt-5">Lista de miembros</h4>
    <div class="box row mt-5 d-flex mx-2 my-custom-scrollbar">

        <table class="table table-hover tableFixHead">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Identificación</th>
                <th scope="col">Nombre</th>
                <th scope="col">Rol <small>(click sobre un rol para cambiarlo)</small></th>
            </tr>
            </thead>
            <tbody>
            @foreach ($miembros as $rol => $array)
                @foreach($array as $miembro)
                    <tr>
                        <th scope="row">{{ $miembro->identificacion }}</th>
                        <td>{{ $miembro->nombreCompleto }}</td>
                        <td>
                            <form action="{{ route('miembros.asignarRol') }}" method="POST">
                                @csrf
                                <input type="hidden" name="nivelJerarquico" value="{{ $nivelJerarquico->componente_id }}">
                                <input type="hidden" name="miembro" value="{{ $miembro->componente_id }}">
                                <input type="hidden" name="viejoRol" value="{{ $rol }}">
                                <select name="rol" class="btn-green-moon btnR justify-content-center"
                                        onchange="mostrarAlertaCambioRol('{{ $rol }}',{{$nivelJerarquico->componente_id}},{{$miembro->componente_id}}, this.value, this.form)">
                                    @foreach($rolesDisponibles as $rolCambio)

                                        <option
                                            value="{{ $rolCambio }}"
                                            {{ $rol == $rolCambio
                                                ||($nivelJerarquico->concreto() instanceof App\Models\NivelPadre && $rolCambio == "miembro")
                                                ? 'disabled'
                                                : ''
                                            }}{{ $rol == $rolCambio
                                                ? ' selected'
                                                :''

                                            }}>
                                            {{ ucfirst($rolCambio) }}
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function mostrarAlertaCambioRol(viejoRol, nivelJerarquico,miembro,nuevoRol, form) {
            if (confirm('¿Está seguro de que quiere cambiar el ' + viejoRol + ' a ' + nuevoRol + '?')){
                form.submit();
                console.log(viejoRol);
                // {{--No funciona :c--}}
                //echo(nivelJerarquico);
                //dd(viejoRol);
                $.ajax('/asignarRol').done((data) => asignarRol(nivelJerarquico,miembro, viejoRol, nuevoRol));
            }
        }

        $(document).ready(function () {
            $(".editButton").click(function () {
                $('#popup').modal('show');
            });
        });
    </script>
@endsection

