@extends('layouts.app')
@section('title', 'Manajemen Transaksi')
@section('custom-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Manajemen Transaksi') }}</div>

                <div class="card-body">
                    {{-- <a href="{{ route('transactions.create') }}" class="btn btn-sm btn-primary mb-3">Tambah Data</a> --}}
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Customer</th>
                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                    {{-- <th>Aksi</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @forelse ($transactions as $transaction)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $transaction->customer->name }}</td>
                                        <td>{{ $transaction->product->name }}</td>
                                        <td>{{ $transaction->total }}</td>
                                        <td><span class="badge rounded-pill text-bg-{{ ($transaction->status === 'successful') ? 'success' : 'danger' }}">{{ ($transaction->status === 'successful') ? 'Sudah Membayar' : 'Belum Membayar' }}</span></td>
                                        {{-- <td class="btn-group">
											<a href="{{ route('transactions.edit', $transaction->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                            <a href="#" class="btn btn-sm btn-danger" onclick="deleteConfirmation({{ $transaction->id }})">Hapus</a>
                                            <form id="delete-form-{{ $transaction->id }}" action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
										</td> --}}
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

    function deleteConfirmation(transactionId) {
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
          document.getElementById('delete-form-' + transactionId).submit();
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
