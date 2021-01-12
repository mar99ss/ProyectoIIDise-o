@extends('layouts.horizontal-layout')

@section('links')
    <link rel="stylesheet" href="{{ mix('css/miembros.css') }}">
    <link rel="stylesheet" href="{{ mix('css/ippopup.css') }}">
    <link rel="stylesheet" href="{{ mix('css/posiciones-jerarquia.css') }}">
    <link rel="stylesheet" href="{{ mix('css/cambio-jerarquia.css') }}">
@endsection

@section('content')
    <div class="row mx-4  mb-2 px-2 d-flex">
        <div class="col-md-5 col-sm-12 d-flex my-3">
            <div class="row mx-0 d-flex justify-content-center">
                <div>
                    <h2 class="nunito-bold">Catalogo de miembros</h2>
                </div>

                    <div class="col-11 mt-2">
                        <form method="get" action="{{ route('miembros.index') }}">
                            <label class="mr-5">Filtrar por:</label>
                            <input class="input-shadow w-100 mr-2 mb-3" type="text" class="form-control inner-shadow "
                                   id="filterby" name="valor" placeholder="Valor a buscar" value="{{ isset($filtro) ? $filtro['valor'] : '' }}">
                            <div class="col-md-12 col-sm-12  mb-3">
                                <input class="" type="radio" name="filtro" value="identificacion" {{ isset($filtro) ? $filtro['filtro'] == 'identificacion' ? 'checked' : '' : 'checked' }}>
                                <label>Identificación</label>
                                <input class="ml-3" type="radio" name="filtro" value="nombreCompleto" {{ isset($filtro) ? $filtro['filtro'] == 'nombreCompleto' ? 'checked' : '' : '' }}>
                                <label for="name">Nombre</label>
                            </div>
                            <button class="btn btn-primary btn-block shadow btn-green-moon" type="submit">Buscar</button>
                        </form>
                        @isset($filtro)
                            <a href="{{ route('miembros.index') }}" class="btn btn-secondary btn-block shadow" type="submit">Eliminar filtro</a>
                        @endisset
                    </div>
            </div>
        </div>

        <div class="col-md-3 ml-5 line-left ">
            <div class="row ">
                <div class="col-md-12 ml-5 my-2 px-0">
                    <p class="nunito-bold py-1">Agregar miembro</p>
                    <button class="btn btn-primary shadow mx-9 btn-green-moon" type="submit"
                            onclick="showIppopupModal()">Agregar nueva persona
                    </button>
                </div>
            </div>
        </div>

        <div class="col-md mx-4">
            <div class="row d-flex justify-content-end ml-0 pl-0">
                <img src="{{ session('movimiento')->logo }}" alt="Logo {{ session('movimiento')->nombre }}"
                     class="movement-logo img-thumbnail border-0">
                <span class="d-md-none d-sm-block space-separator"></span>
            </div>
        </div>
    </div>

    <h4 class="pt-5">Lista de miembros</h4>
    <div class="box mt-4 my-custom-scrollbar">

        <table class="table table-hove tableFixHead">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Identificación</th>
                <th scope="col">Nombre</th>
                <th scope="col">Teléfono</th>
                <th scope="col">Correo Electrónico</th>
                <th scope="col">Información Personal</th>
                <th scope="col">Posiciones en jerarquía</th>
                <th scope="col">Eliminar</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($miembros as $miembro)
                <tr>
                    <th scope="row">{{ $miembro->identificacion }}</th>
                    <td>{{ $miembro->nombreCompleto }}</td>
                    <td class="text-nowrap">{{ $miembro->telefono }}</td>
                    <td>{{ $miembro->email }}</td>
                    <td>
                        <button class="btn btn-primary shadow btn-green-moon" class="editButton" type="submit"
                                onclick="showIppopupModal({{ $miembro }})">Editar
                        </button>
                    </td>
                    <td>
                        <button class="btn btn-primary shadow btn-green-moon mx-4" type="submit"
                                onclick="showModalPosicionesJerarquia({{ $miembro }})">Ver
                        </button>
                    </td>
                    <td>
                        <form action="{{ route('miembros.destroy', $miembro) }}" method="post">
                            @method('delete')
                            @csrf
                            <button class="btn btn-primary shadow btn-red" type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @include('partials.ippopup')
    @include('partials.posiciones-jerarquia')
@endsection
