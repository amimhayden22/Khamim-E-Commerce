@extends('frontend.layouts.app')
@section('title', 'Pembelian Berhasil')
@section('content')
<section class="my-3">
    <div class="jumbotron px-3 py-4 px-sm-4 py-sm-5 bg-light rounded-3 mb-3">
        <div class="text-center">
            <img src="https://cdn-icons-png.flaticon.com/512/5610/5610944.png" alt="Icon Berhasil" class="img-fluid" width="100">
            <h1 class="display-4">Pembelian Produk Berhasil</h1>
            <p class="lead">Terima kasih sudah membeli produk kami, semoga sehat selalu!</p>
            <a class="btn btn-primary" href="{{ url('our-products') }}" role="button">Lihat Produk Lain</a>
        </div>
    </div>
</section>
@endsection
