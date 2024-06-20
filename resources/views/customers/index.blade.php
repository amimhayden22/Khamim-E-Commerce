@extends('layouts.app')
@section('title', 'Data Customer')
@section('custom-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Data Customer') }}</div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Nomor HP</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @forelse ($customers as $customer)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $customer->name }}</td>
                                        <td>{{ $customer->email }}</td>
                                        <td>{{ $customer->phone }}</td>
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
