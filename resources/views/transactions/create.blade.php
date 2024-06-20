@extends('layouts.app')
@section('title', 'Tambah Transaksi')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Form Tambah Transaksi') }}</div>

                <div class="card-body">
                    <form >
                        @csrf
                        <div class="mb-3">
                            <label for="product_id">Nama Produk</label>

                            <div class="">
                                <select name="product_id" id="product_id" class="form-control @error('product_id') is-invalid @enderror" required>
                                    <option value="" selected disabled>--- Pilih Nama Produk ---</option>
                                    @foreach ($products as $product)
                                        <option value="{{ $product->id }}" {{ (old('product_id') === $product->id) ? 'selected' : '' }}>{{ $product->name }}</option>
                                    @endforeach
                                </select>
                                @error('product_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary float-end" id="buy-product">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom-js')
<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.clientKey') }}"></script>
<script type="text/javascript">
	$('#buy-product').click(function(event) {
		event.preventDefault();
		$.post("{{ route('transactions.store') }}", {
			_method: 'POST',
			_token: '{{ csrf_token() }}',
            product_id: $('#product_id').val(),
		}, function(data, status) {
            // console.log(data['snap_token']);
			snap.pay(data['snap_token'], {
				onSuccess: function(result) {
                    console.log(result.order_id);
                    // alert('Transaksi berhasil');
                    var order_id = result.order_id;
                    $.post("{{ url('/dasbor/transactions') }}/" + order_id, {
                        _method: 'PUT',
                        _token: '{{ csrf_token() }}',
                        transaction_id: order_id,
                        status: 'paid',
                        quantity: 1,
                    }, function(data, status) {
                        console.log(data);
                        // location.reload();
                    });
				},
				onPending: function(result) {
					location.reload();
				},
				onError: function(result) {
					location.reload();
				}
			});
			return false;
		});
	});
</script>
@endsection
