{{--

  ____          _____               _ _           _
 |  _ \        |  __ \             (_) |         | |
 | |_) |_   _  | |__) |_ _ _ __ _____| |__  _   _| |_ ___
 |  _ <| | | | |  ___/ _` | '__|_  / | '_ \| | | | __/ _ \
 | |_) | |_| | | |  | (_| | |   / /| | |_) | |_| | ||  __/
 |____/ \__, | |_|   \__,_|_|  /___|_|_.__/ \__, |\__\___|
         __/ |                               __/ |
        |___/                               |___/

    Blog:       https://parzibyte.me/blog
    Ayuda:      https://parzibyte.me/blog/contrataciones-ayuda/
    Contacto:   https://parzibyte.me/blog/contacto/

    Copyright (c) 2020 Luis Cabrera Benito
    Licenciado bajo la licencia MIT

    El texto de arriba debe ser incluido en cualquier redistribucion
--}}
@extends('maestra')
@section("titulo", "Inicio")
@section('contenido')
    <div class="col-12 text-center">
        <h1>Bienvenido, {{Auth::user()->name}}</h1>
    </div>
    @foreach([
    ["productos", "ventas", "vender", "clientes"],
    ["usuarios", "acerca_de", "soporte"]
    ] as $modulos)
        <div class="col-12 pb-2">
            <div class="row">
                @foreach($modulos as $modulo)
                    <div class="col-12 col-md-3">
                        <div class="card bg-light shadow-lg rounded">
                            <a href="{{route("$modulo.index")}}" class="card-body">
                                <img class="card-img-top" src="{{url("/img/$modulo.png")}}">
                                <h5 class="card-title">
                                    {{$modulo === "acerca_de" ? "Acerca de" : ucwords($modulo)}}
                                </h5>
                                <div class="btn btn-primary">
                                        Ir a&nbsp;{{$modulo === "acerca_de" ? "Acerca de" : ucwords($modulo)}}
                                        <i class="fa fa-arrow-right"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
@endsection
