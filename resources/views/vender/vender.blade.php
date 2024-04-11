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
@extends("maestra")
@section("titulo", "Realizar venta")
@section("contenido")
    <div class="row">
        <div class="col-12">
            <h1>Nueva venta <i class="fa fa-cart-plus"></i></h1>
            @include("notificacion")
            <div class="row">
                <div class="col-12 col-md-6">
                    <form action="{{route("terminarOCancelarVenta")}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="id_cliente">Cliente</label>
                            <select required class="form-control" name="id_cliente" id="id_cliente">
                                @foreach($clientes as $cliente)
                                    <option value="{{$cliente->id}}">{{$cliente->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        @if(session("productos") !== null)
                            <div class="form-group">
                                <button name="accion" value="terminar" type="submit" class="btn btn-success">Terminar
                                    venta
                                </button>
                                <button name="accion" value="cancelar" type="submit" class="btn btn-danger">Cancelar
                                    venta
                                </button>
                            </div>
                        @endif
                    </form>
                </div>
                <div class="col-12 col-md-6">
                    <form action="javascript:void(0);">
                        @csrf
                        <div class="form-group">
                            <label for="codigo">Código de barras</label>
                            <input id="codigo" autocomplete="off" required autofocus name="codigo" type="text"
                                   class="form-control"
                                   placeholder="Código de barras">
                            <div class="list"></div>
                        </div>
                    </form>
                </div>
            </div>
            @if(session("productos") !== null)
                <h2>Total: ${{number_format($total, 2)}}</h2>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Código de barras</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Quitar</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach(session("productos") as $producto)
                            <tr>
                                <td>{{$producto->codigo_barras}}</td>
                                <td>{{$producto->descripcion}}</td>
                                <td>${{number_format($producto->precio_venta, 2)}}</td>
                                <td>{{$producto->cantidad}}</td>
                                <td>
                                    <form action="{{route("quitarProductoDeVenta")}}" method="post">
                                        @method("delete")
                                        @csrf
                                        <input type="hidden" name="indice" value="{{$loop->index}}">
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <h2>Aquí aparecerán los productos de la venta
                    <br>
                    Escanea el código de barras o escribe y presiona Enter</h2>
            @endif
        </div>
    </div>
    <script type="text/javascript">
        const path = `{{route("buscarProducto")}}` 
        // catch event keyup and find barcode or product name
        document.getElementById('codigo').addEventListener('keyup', (e) => {
            e.preventDefault()
            const codigo = document.getElementById('codigo')
            const csrfToken = document.head.querySelector("[name=csrf-token]").content;
            const listItemContainer = document.querySelector('.list')
            if(codigo.value.length === 0)
                listItemContainer.innerHTML = "";
            if(codigo.value.length >= 3) {
                fetch(path,{
                    headers: {
                        "X-CSRF-Token": csrfToken,
                        "Content-Type": "application/json"
                    },
                    credentials: "same-origin",
                    method: 'POST',
                    dataType: 'JSON',
                    data: JSON.stringify({codigo: codigo}),
                }).then(res => res.json())
                .then(response => {
                    // console.log(response.data)
                    if(Object.entries(response.data).length === 0)
                        console.log("empty")
                    

                    listItemContainer.innerHTML = ""

                    response.data.forEach(item => {
                        const tagElement = document.createElement('a')
                        tagElement.textContent = `${item.codigo_barras} - ${item.descripcion}`
                        tagElement.classList.add('tag')
                        
                        listItemContainer.appendChild(tagElement)
                    })
                })
                .catch(error => {
                    console.log(error)
                })
            }
            
        })
    </script>
    <style>
        .list {
            display: flex;
            flex-flow: wrap column;
            position: absolute;
        }

        .tag {
            padding: 0.4em;
            border: 1px solid #ced4da;
            border-radius: 5px;
            min-width: 6em;
            width: 15em;
            margin-bottom: 0.2em;
            cursor: pointer;
            z-index: 9;
            box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
        }
    </style>
@endsection
