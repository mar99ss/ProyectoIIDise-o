@extends('layouts.horizontal-layout')

@section('links')
    <link rel="stylesheet" href="{{ mix('css/admin.index.css') }}">
@endsection

@section('content')
    <div class="row mx-4 mb-5 px-2 d-flex align-items-center">
        <div class="col-lg-2 col-md-12 mb-md-5 d-flex flex-column">
            <img src="{{ $movimiento->logo }}" alt="Logo {{ $movimiento->nombre }}" class="movement-logo">
            <span class="d-md-none d-sm-block space-separator"></span>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 px-lg-5 d-flex justify-content-center align-content-center">
            <div class="d-flex flex-column w-100 justify-content-center align-content-center p-md-3 p-lg-0">
                @include('admin.__text-item', ['title' => 'Movimiento', 'text' => $movimiento->nombre])
                @include('admin.__text-item', ['title' => 'Cédula jurídica', 'text' => $movimiento->cedulaJuridica])
                @include('admin.__text-item', ['link' => $movimiento->direccionWeb])
                @include('admin.__text-item', ['title' => 'Raíz', 'text' => $movimiento->raiz()->nombre])
            </div>
        </div>

        <div class="col-lg-6 col-md-6 col-sm-12 line-left px-lg-5">
            <div class="row mx-0 p-md-3">
                <div class="col-md-6 my-2 px-0">
                    <b>Pais:</b> {{ $movimiento->pais }}
                </div>
                <div class="col-md-6 my-2 px-0">
                    <b>Provincia:</b> {{ $movimiento->provincia }}
                </div>
                <div class="col-md-6 my-2 px-0">
                    <b>Cantón:</b> {{ $movimiento->canton }}
                </div>
                <div class="col-md-6 my-2 px-0">
                    <b>Distrito:</b> {{ $movimiento->distrito }}
                </div>
                <div class="col-12 my-2 px-0">
                    <b>Señas: </b> {{ $movimiento->sennas }}
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-around py-lg-5">

        <div class="col-md-3 col-sm-12 my-2 roundedBorders">
            @include('admin.__info-item', [
                    'number' => '85 ',
                    'description' => 'Miembros',
                    'pngImage' => 'indexMember'
                ])
        </div>
        <div class="col-md-3 col-sm-12 my-2  roundedBorders">
            @include('admin.__info-item', [
                'number' => '57',
                'description' => 'Nodos creados',
                'pngImage' => 'indexCreatedNodes'
            ])

        </div>
        <div class="col-md-3 col-sm-12 my-2  roundedBorders">
            @include('admin.__info-item', [
                'number' => '35',
                'description' => 'Nodos finales',
                'pngImage' => 'indexFinalNodes'
            ])
        </div>

    </div>

    <span class="hline"></span>

    <div class="row row-content ml-3 py-lg-5">
        <div class="col-12">
            <h6 class="nunito-bold">Editar datos del movimiento</h6>
        </div>
        <div class="col-12 col-md-12">
        <form method="post" action="{{ route('admin.edit', $movimiento) }}">
                @method('PATCH')
                @csrf
                <div class="form-group row">

                    <div class="col-md-3">
                        <label for="name">Nombre</label>
                        <input type="text" class="form-control inner-shadow " id="name" name="nombre" placeholder="{{ $movimiento->nombre }}">
                    </div>
                    <div class="col-md-3">
                        <label for="country">Pais</label>
                        <input type="text" class="form-control inner-shadow " id="country" name="pais" placeholder="{{ $movimiento->pais }}">
                    </div>
                    <div class="col-md-3">
                        <label for="canton">Canton</label>
                        <input type="text" class="form-control inner-shadow " id="canton" name="canton" placeholder="{{ $movimiento->canton }}">
                    </div>
                    <div class="col-md-3">
                        <label for="signals">Señas</label>
                        <textarea class="form-control inner-shadow " id="signals" name="sennas" rows="2" placeholder="{{ $movimiento->sennas }}"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-3">
                        <label for="web">Sitio web</label>
                        <input type="text" class="form-control inner-shadow " id="web" name="direccionWeb" placeholder="{{ $movimiento->direccionWeb }}">
                    </div>
                    <div class="col-md-3">
                        <label for="state">Provincia</label>
                        <input type="text" class="form-control inner-shadow " id="state" name="provincia" placeholder="{{ $movimiento->provincia }}">
                    </div>
                    <div class="col-md-3">
                        <label for="district">Distrito</label>
                        <input type="text" class="form-control inner-shadow " id="district" name="distrito" placeholder="{{ $movimiento->distrito }}">
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button class="btn btn-primary shadow mx-9 btn-green-moon" type="submit">Actualizar</button>
                    </div>
                </div>
            </form>

        </div>
        <div class="col-12 col-md">
        </div>
    </div>

    </div>
@endsection
