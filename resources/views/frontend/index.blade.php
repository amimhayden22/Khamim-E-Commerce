@extends('frontend.layouts.app')
@section('title', 'Beranda')
@section('content')
<section class="my-3">
    <div class="jumbotron px-3 py-4 px-sm-4 py-sm-5 bg-light rounded-3 mb-3">
        <h1 class="display-4">Halo, Selamat Datang di Khamim E-Commarce</h1>
        <p class="lead">Anda dapat mencari produk apapun di website kami</p>
        <a class="btn btn-primary btn-lg" href="{{ url('our-products') }}" role="button">Lihat Produk</a>
    </div>
</section>
@endsection
