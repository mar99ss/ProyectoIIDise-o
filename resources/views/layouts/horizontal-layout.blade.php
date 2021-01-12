@extends('layouts.general-layout')

@section('hlinks')
    @yield('links')
    <link rel="stylesheet" href="{{ mix('css/horizontal-layout.css') }}">
@endsection

@section('hcontent')
    <div class="vertical-navbar">
        <a href="/"><img src="{{ asset('img/logo.png') }}" alt=""></a>
        <div class="items">
            @include('layouts.__nav')
        </div>
    </div>

    <div class="content">
        @yield('content')
    </div>
@endsection

@section('hscripts')
    @yield('scripts')
@endsection
