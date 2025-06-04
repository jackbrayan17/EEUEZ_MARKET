@extends('layout.app')

@section('content')
<div class="container mx-auto">
    <h2 class="text-2xl font-semibold mb-4">{{ $storefront->name }} - Products</h2>

    <ul>
        @foreach ($storefront->products as $product)
            <li>{{ $product->name }} - ${{ $product->price }}</li>
        @endforeach
    </ul>
</div>
@endsection
