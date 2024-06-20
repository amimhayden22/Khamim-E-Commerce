@extends('frontend.layouts.app')
@section('title', 'Produk Kami')
@section('content')
<section class="my-3">
    <h1 class="text-center">Produk Unggulan Kami</h1>
    <div class="row card-group">
        @forelse ($products as $product)
            <div class="col-lg-3 col-sm-12 p-3">
                <div class="card" style="width: 18rem;">
                    <img src="{{ asset('assets/img/products/'.$product->image) }}" class="card-img-top" alt="Gambar {{ $product->name }}">
                    <div class="card-body">
                        <h4 class="card-title">{{ $product->name }}</h4>
                        <p>
                            Stok: <strong>{{ $product->stock }}</strong>
                            <br>
                            Harga: <strong>Rp {{ number_format($product->price, 0, ',', '.') }}</strong>
                        </p>
                        <p class="card-text">
                            {{ $product->description }}
                        </p>
                    </div>
                    <div class="card-body">
                        <a href="{{ url('/our-products/'.$product->slug) }}" class="btn btn-success {{ ($product->stock === 0 ? 'disabled' : '') }} float-end">Beli Sekarang</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="mt-5 small">Untuk saat ini <code>Produk</code> belum tersedia, mohon di tunggu ya :D</p>
        @endforelse
    </div>
</section>
@endsection
