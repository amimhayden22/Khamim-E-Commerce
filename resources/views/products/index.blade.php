@extends('layouts.app')
@section('title', 'Manajemen Produk')
@section('custom-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Manajemen Produk') }}</div>

                <div class="card-body">
                    <a href="{{ route('products.create') }}" class="btn btn-sm btn-primary mb-3">Tambah Data</a>
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Stok</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @forelse ($products as $product)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ $product->stock }}</td>
                                        <td><span class="badge rounded-pill text-bg-{{ ($product->status === 'active') ? 'success' : 'danger' }}">{{ ($product->status === 'active') ? 'Aktif' : 'Tidak Aktif' }}</span></td>
                                        <td class="btn-group">
											<a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="#" class="btn btn-sm btn-danger" onclick="deleteConfirmation({{ $product->id }})">Hapus</a>
                                            <form id="delete-form-{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
										</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">Data tidak ada...</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom-js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Success Data -->
@if (Session::has('success'))
<script>
    Swal.fire({
        title: "Sukses!",
        text: "{{ Session('success') }}",
        icon: "success"
    });
</script>
@endif
<!-- Delete Data -->
<script>
    const swalWithBootstrapButtons = Swal.mixin({
      customClass: {
        confirmButton: "btn btn-success",
        cancelButton: "btn btn-outline-danger"
      },
      buttonsStyling: false
    });

    function deleteConfirmation(productId) {
      swalWithBootstrapButtons.fire({
        title: "Apakah kamu yakin?",
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Hapus Sekarang!",
        cancelButtonText: "Batalkan!",
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
          document.getElementById('delete-form-' + productId).submit();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
          swalWithBootstrapButtons.fire({
            title: "Dibatalkan!",
            text: "Data kamu aman :)",
            icon: "error"
          });
        }
      });
    }
  </script>

@endsection
