@extends('layout.index')

@section('content')
    @if (session('info'))
        <div class="alert alert-success" role="alert">
            {{ session('info') }}
        </div>
    @endif
    <div class="container">
        <div class="mt-2">
            <div class="form-group">
                @if (!$sale->client)
                    <p>Agregar cliente</p>
                    <form action="{{ route('sale.client', $sale) }}" method="POST">
                        @csrf
                        @method('put')
                        <label>Seleciona un cliente</label>
                        <select class="form-control" name="client">
                            <option value="">--Selecciona--</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}" id="option">{{ $client->name }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-info mt-4">
                            agregar cliente
                        </button>
                    </form>
                @else
                    <div class="alert alert-info">
                        <p class="text-uppercase">Datos de cliente</p>
                        <p>{{ $sale->client->name }} {{ $sale->client->lastname }}</p>
                        <p>{{ $sale->client->phone }}</p>
                    </div>
                @endif
            </div>
            <div class="d-flex justify-content-between">
                <div>
                    <p>Buscar productos</p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProduct">
                        Buscar producto
                    </button>
                </div>
                @if (!$temporary->isEmpty())
                    <div>
                        <form action="{{ route('sale.new', $sale) }}" method="POST">
                            @csrf
                            <p>Procesar venta</p>
                            <button class="btn btn-success">
                                Procesar venta
                            </button>
                        </form>
                    </div>
                @endif
            </div>
            @include('sales.partials.products-index', ['sale'=>$sale])
        </div>
        <div class="overflow-auto">
            <table class="table mt-5">
                <thead class="table-dark">
                    <tr>
                        <th>Código</th>
                        <th>Descripcion</th>
                        <th>Cantidad</th>
                        <th>Total</th>
                        <th colspan="2">Acciones</th>
                    </tr>
                </thead>
                <tbody class="">
                    @forelse ($temporary as $temporary)
                        <tr>
                            <td>{{ $temporary->product->code }}</td>
                            <td>{{ $temporary->product->description }}</td>
                            <td>{{ $temporary->quantity }}</td>
                            <td>${{ $temporary->total }}</td>
                            <td>
                                <form action="{{ route('sales.destroy', $temporary) }}" method="post">
                                    @method('delete')
                                    @csrf
                                    <button class="btn btn-sm btn-danger">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No hay usuarios en existencia</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
