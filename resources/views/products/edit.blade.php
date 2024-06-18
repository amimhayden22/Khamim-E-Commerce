@extends('layouts.app')
@section('title', 'Edit Produk')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Form Edit Produk') }}</div>

                <div class="card-body">
                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name">Nama</label>

                            <div class="">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $product->name) }}" placeholder="Contoh: Gus Khamim" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class=" mb-3">
                            <label for="price">Harga</label>
                            <div class="input-group">
                                <span class="input-group-text" id="price">Rp</span>
                                <input id="price" type="text" class="form-control @error('price') is-invalid @enderror" name="price" value="{{ old('price', $product->price) }}" placeholder="Contoh: 5000000" required autocomplete="price">

                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="stock">Stok</label>

                            <div class="">
                                <input id="stock" type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" value="{{ old('stock', $product->stock) }}" placeholder="Contoh: 2" required autocomplete="stock" autofocus>

                                @error('stock')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" name="description" id="description" rows="3" placeholder="Contoh: Produk ini lengkap dan baru...">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Foto</label>
                            @if ($product->image)
                                <br>
                                <img src="{{ asset('assets/img/products/' . $product->image) }}" class="img-thumbnail mb-3" alt="Foto {{ $product->name }}" width="150">
                                (Foto saat ini)
                            @else
                                <span class="badge rounded-pill text-bg-info">Foto belum diunggah</span>
                            @endif
                            <input class="form-control @error('image') is-invalid @enderror" name="image" type="file" id="image">
                            <span class="form-text">Foto berupa .png/.jpg/.jpeg dengan ukuran maks 2mb.</span>
                            @error('image')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status">Status</label>

                            <div class="">
                                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                    <option value="" selected disabled>--- Pilih Status ---</option>
                                    <option value="active" {{ (old('status', $product->status) === 'active') ? 'selected' : '' }}>Aktif</option>
                                    <option value="inactive" {{ (old('status', $product->status) === 'inactive') ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                                @error('status')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary float-end">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
