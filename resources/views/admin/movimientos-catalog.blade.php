@extends('layouts.general-layout')

@section('hlinks')
    <link rel="stylesheet" href="{{ mix('css/movimientos-catalog.css') }}">
@endsection

@section('hcontent')
    <form method="POST" action="{{ route('movimiento.create') }}" >
        @csrf
        <div class="row mx-4  mb-2 px-2 d-flex">

            <div class="col-md-3 col-sm-12 my-3">
                <h2 class="nunito-bold">Catalogo de movimientos</h2>
                <br>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
            <div class="col-md-6 col-sm-12 d-flex my-3 line-left">
                <div class="row mx-0 d-flex justify-content-center">
                    <div class="col-md-6 mt-2">
                        <label class="mr-5">Cédula Jurídica</label>
                        <input class="innerShadow w-100 mr-2 mb-3" type="text" class="form-control" id="cedulaJuridica"
                               name="cedulaJuridica" placeholder="3-TTT-CCCCCC" value="3-TTT-CCCCCC">

                        <label class="mr-5">Nombre</label>
                        <input class="innerShadow w-100 mr-2 mb-3" type="text" class="form-control" id="nombre"
                               name="nombre" placeholder="Nombre movimiento" value="Mi movimiento">

                        <label class="mr-5">Pais</label>
                        <input class="innerShadow w-100 mr-2 mb-3" type="text" class="form-control" id="country"
                                name="pais" placeholder="Costa Rica" value="Costa Rica">

                        <label class="mr-5">Provincia</label>
                        <input class="innerShadow w-100 mr-2 mb-3" type="text" class="form-control" id="provincia"
                                name="provincia" placeholder="Cartago" value="Cartago">
                    </div>
                    <div class="col-md-6 mt-2">
                        <label class="mr-5">Canton</label>
                        <input class="innerShadow w-100 mr-2 mb-3" type="text" class="form-control" id="canton"
                                name="canton" placeholder="Oreamuno" value="Oreamuno">
                        <label class="mr-5">Distrito</label>
                        <input class="innerShadow w-100 mr-2 mb-3" type="text" class="form-control" id="distrito"
                                name="distrito" placeholder="San Rafael" value="San Rafael">
                        <label class="mr-5">Señas</label>
                        <input class="innerShadow w-100 mr-2 mb-3" type="text" class="form-control" id="dirFisica"
                               name="sennas" placeholder="100 metros sur del centro" value="100 metros sur del centro">
                        <label class="mr-5">Dirección Web</label>
                        <input class="innerShadow w-100 mr-2 mb-3" type="text" class="form-control" id="dirWeb"
                               name="direccionWeb" placeholder="www.movimiento.com" value="www.movimiento.com">

                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-12 d-flex my-3">
                <div class="mx-0">
                    <div id="telefonos">
                        <div id="template" class="d-none">
                            <div class="position-relative">
                                <img class="eliminar" src="{{ asset('svg/recycle-bin.svg') }}">
                                <input type="text" class="telefono position-relative innerShadow mt-1" placeholder="22334455">
                            </div>
                        </div>
                        <label>Telefonos</label>
                        <span class="btn btn-primary btn-green-moon ml-3 " onclick="nuevoTelefono()">Agregar</span>
                        <div class="horizontal-scroll">
                        </div>
                        <label class="mr-5">Logo</label>
                        <input class="innerShadow w-100 mr-2 mb-3" type="text" class="form-control" id="logo" name="logo"
                               placeholder="http://mi-logo/img.png" value="https://4.bp.blogspot.com/-tt7LkKVEh4Q/XE9KoE7qDyI/AAAAAAAAHc4/WtyfY5iA-doY2BIQ27eQiTnqQwCbd6g0QCK4BGAYYCw/s1600/Logo%2BInstagram%2BVector.png">

                        <label class="mr-5">Nombre de la coordinación</label>
                        <input class="innerShadow w-100 mr-2 mb-3" type="text" class="form-control" id="nombreCoordinacion" name="nombreCoordinacion"
                               placeholder="Coordinación CR" value="Coordinación Costa Rica">

                        <button class="btn btn-primary btn-green-moon mt-5">Agregar movimiento</button>
                    </div>

                </div>
            </div>
        </div>
    </form>
        <div>
            <div class="box d-flex mx-5 mt-5 justify-content-center my-custom-scrollbar">
                <table class="table table-hove tableFixHead  ">

                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Cedula Juridica</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Direccion web</th>
                        <th scope="col">Direccion geográfica</th>
                        <th scope="col">Telefono</th>
                        <th scope="col">Logo</th>
                        <th scope="col"> </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach  ($movimientos as $movimiento)
                        <tr>
                            <th scope="row">{{ $movimiento->cedulaJuridica }}</th>
                            <td>{{ $movimiento->nombre }}</td>
                            <td>{{ $movimiento->direccionWeb }}</td>
                            <td>{{ $movimiento->sennas }}</td>
                            <td>{{ $movimiento->telefonos()->exists() ? implode(", ", $movimiento->telefonos()->get()->pluck("numero")->toArray()) : "" }}</td>
                            <td><img src="{{ $movimiento->logo }}" alt="logo" width="50" height="50"></td>
                            <td> <a href="{{ route('admin', compact('movimiento')) }}" class="btn btn-primary shadow">Administrar</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
@endsection

@section('hscripts')
    <script>
        let cantChilden = 0;

        function nuevoTelefono() {
            const template = $("#template").clone();
            console.log(template);

            template.removeClass('d-none');
            const btnEliminar = $(template).find('.eliminar')[0];

            const ref = cantChilden.valueOf();

            $(btnEliminar).click(function () {
                eliminarTelefono(ref);
            });

            const telefono = $(template).find('.telefono')[0];
            $(telefono).attr('name', 'telefonos[]');

            $(template).attr('id', "telefono" + cantChilden.valueOf());

            $(".horizontal-scroll").append(template);

            cantChilden++;
        }

        function eliminarTelefono(id) {
            $("#telefono" + id).remove();
        }

    </script>
@endsection
