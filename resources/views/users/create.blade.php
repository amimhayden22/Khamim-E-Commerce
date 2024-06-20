@extends('layouts.app')
@section('title', 'Tambah Pengguna')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Form Tambah Pengguna') }}</div>

                <div class="card-body">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="role" value="role">
                        <div class="mb-3">
                            <label for="name">Nama</label>

                            <div class="">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Contoh: Gus Khamim" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email">Email</label>

                            <div class="">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Contoh: khamim@gmail.com" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password">Password</label>

                            <div class="">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Masukkan password..." required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password-confirm">Konfirmasi Password</label>

                            <div class="">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Konfirmasi ulang password..." required autocomplete="new-password">
                            </div>
                        </div>

                        {{-- <div class="mb-3">
                            <label for="role">Role</label>

                            <div class="">
                                <select name="role" id="role" class="form-control @error('role') is-invalid @enderror" required>
                                    <option value="" selected disabled>--- Pilih Role ---</option>
                                    <option value="Admin" {{ (old('role') === 'Admin') ? 'selected' : '' }}>Admin</option>
                                    <option value="Customer" {{ (old('role') === 'Customer') ? 'selected' : '' }}>Customer</option>
                                </select>
                                @error('role')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div> --}}
                        <button type="submit" class="btn btn-primary float-end">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
