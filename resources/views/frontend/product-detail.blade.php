@extends('frontend.layouts.app')
@section('title', 'Produk '.$product->name)
@section('custom-css')
<style>
    input:read-only {
        background-color: #e9ecef;
    }
</style>
@endsection
@section('content')
<section class="mt-3 mb-5">
    <h1 class="text-center">{{ $product->name }}</h1>
    <img src="{{ asset('assets/img/products/'.$product->image) }}" alt="Foto {{ $product->name }}" class="img-fluid rounded mx-auto d-block my-3" width="150px">
    <hr>
    <p>
        Stok: <strong>{{ $product->stock }}</strong>
        <br>
        Harga: <strong>Rp {{ number_format($product->price, 0, ',', '.') }}</strong>
        <br>
        {{ $product->description }}
    </p>
    <hr>
    <p>
        Untuk pembelian produk ini silakan isi form berikut:
    </p>
    <form action="" method="post" class="">
        @csrf
        <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
        <input type="hidden" name="total" id="total">
        <div class="form-floating mb-3">
            <input type="text" name="name" class="form-control required-input" id="name" placeholder="Contoh: Gus Khamim" required>
            <label for="name">Nama Lengkap</label>
        </div>
        <div class="form-floating mb-3">
            <input type="email" name="email" class="form-control required-input" id="email" placeholder="Contoh: name@example.com" required>
            <label for="email">Alamat Email</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="phone" class="form-control required-input" id="phone" placeholder="Contoh: 081215123321" required>
            <label for="phone">Nomor WhatsApp</label>
        </div>
        <div class="form-floating mb-3">
            <input type="number" name="quantity" class="form-control required-input" id="quantity" placeholder="Contoh: 081215123321" min="1" required>
            <label for="quantity">Jumlah produk yang dibeli</label>
        </div>
        <div class="form-floating mb-3">
            <input type="text" name="totalRp" class="form-control required-input" id="totalRp" placeholder="Contoh: 081215123321" readonly>
            <label for="totalRp">Harga Total</label>
        </div>
        <button type="submit" id="checkout-now" class="btn btn-primary float-end mb-3">Beli Sekarang</button>
    </form>
</section>
<br>
@endsection
@section('custom-js')
<script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.clientKey') }}"></script>
<script type="text/javascript">
    $(document ).ready(function() {
        $('#checkout-now').attr('disabled', 'disabled');
        // Calculate total price
        $("#quantity").on("input", function() {
            var quantity = $(this).val();
            var stock = {{ $product->stock }};
            var price = {{ $product->price }};

            // Check Stock
            if (quantity > stock) {
                // alert('Stok tidak mencukupi');
                quantity = stock;
                $(this).val(stock);
            }

            // Calculate total price
            var total = quantity * price;
            const rupiah = (number) => {
                return new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR"
                }).format(number);
            }

            $("#total").val(total);
            $("#totalRp").val(rupiah(total));
        });

        // Create function for check all input
        function checkInputs() {
            var allFilled = true;
            $('.required-input').each(function() {
                if ($(this).val() === '') {
                    allFilled = false;
                    return false; // Break the loop
                }
            });
            return allFilled;
        }

        // Check inputs on keyup and change events
        $('.required-input').on('keyup change', function() {
            if (checkInputs()) {
                $('#checkout-now').removeAttr('disabled');
            } else {
                $('#checkout-now').attr('disabled', 'disabled');
            }
        });

        // Initial check on page load
        if (checkInputs()) {
            $('#checkout-now').removeAttr('disabled');
        }

        // Checkout with Midtrans
        $('#checkout-now').click(function(event) {
            event.preventDefault();
            // alert('Checkout now is clicked');
            $.post("{{ url('/our-products/checkout') }}", {
                _method: 'POST',
                _token: '{{ csrf_token() }}',
                product_id: $('#product_id').val(),
                name: $('#name').val(),
                email: $('#email').val(),
                phone: $('#phone').val(),
                quantity: $('#quantity').val(),
                total: $('#total').val(),
            }, function(data, status) {
                // console.log(data['snap_token']);
                snap.pay(data['snap_token'], {
                    onSuccess: function(result) {
                        console.log(result.order_id);
                        // alert('Transaksi berhasil');
                        var order_id = result.order_id;
                        $.post("{{ url('/our-products/checkout/update-stock') }}/" + order_id, {
                            _method: 'POST',
                            _token: '{{ csrf_token() }}',
                            transaction_id: order_id,
                            status: 'successful',
                            quantity: $('#quantity').val(),
                        }, function(data, status) {
                            window.location.href = "{{ url('/our-products/checkout/success') }}";
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
    });
</script>
@endsection
