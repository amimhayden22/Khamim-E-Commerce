<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    public function __construct()
    {
        Config::$serverKey    = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized  = config('services.midtrans.isSanitized');
        Config::$is3ds        = config('services.midtrans.is3ds');
    }

    public function index()
    {
        return view('frontend.index');
    }

    public function product()
    {
        $products = Product::where('status', 'Active')->get();

        return view('frontend.products', compact('products'));
    }

    public function productDetail($slug)
    {
        $product = Product::where('slug', $slug)->first();
        if ($product->stock == 0) {
            return redirect()->back()->with('error', 'Maaf, produk ini sudah habis.');
        }
        return view('frontend.product-detail', compact('product'));
    }

    public function checkout(Request $request)
    {
        $product = Product::find($request->product_id);

        $customer = Customer::create([
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        $transaction = Transaction::create([
            'customer_id'   => $customer->id,
            'product_id'    => $product->id,
            'quantity'      => $request->quantity,
            'total'         => $request->total,
            'status'        => 'pending',
        ]);

        $payload = [
            'transaction_details' => [
                'order_id'     => $transaction->id,
                'gross_amount' => $transaction->total,
            ],
            'customer_details' => [
                'first_name' => $customer->name,
                'email'      => $customer->email,
            ],
            'item_details' => [
                [
                    'id'            => $transaction->id,
                    'price'         => $transaction->total,
                    'quantity'      => 1,
                    'name'          => $product->name,
                    'brand'         => 'Khamim E-Commerce',
                    'category'      => 'Pembelian Produk',
                    'merchant_name' => 'The Origin Project',
                ],
            ],
        ];

        $snapToken = Snap::getSnapToken($payload);
        $transaction->snap_token = $snapToken;
        $transaction->save();

        $this->response['snap_token'] = $snapToken;

        return response()->json($transaction, 200);
    }

    public function updateStock(Request $request, $id)
    {
        $transaction = Transaction::find($id);

        $transaction->update([
            'status' => $request->status,
        ]);

        $product = Product::find($transaction->product_id);
        $product->stock = $product->stock - $request->quantity;
        $product->save();

        return response()->json($product, 200);
    }

    public function checkoutSuccess()
    {
        return view('frontend.checkout-success');
    }
}
