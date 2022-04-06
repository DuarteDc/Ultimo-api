@extends('layout.index')

@section('content')
    <div class="container my-5">
        <h2 class="text-center my-5">Productos</h2>
        <div class="row">
            @foreach ($products as $product)
                <div class="col-sm-12 col-md-6 col-lg-4">
                    <div class="card">
                        <img src="{{ $product->get_photo }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <p class="card-text">{{ $product->name }}</p>
                            <p class="card-text">${{ $product->precio }}</p>
                            <p class="card-text">{{$product->get_status_product}}</p>
                            <form action="{{ route('cart.add', $product) }}" method="post">
                                @csrf
                                <button class="btn btn-success">Añadir al carrito</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
