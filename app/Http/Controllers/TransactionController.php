<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function __construct()
    {
        Config::$serverKey    = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized  = config('services.midtrans.isSanitized');
        Config::$is3ds        = config('services.midtrans.is3ds');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::with('customer', 'product')->get();

        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::where('status', 'Active')->get();

        return view('transactions.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = Product::find($request->product_id);
        // return response()->json($product, 200);
        $transaction = Transaction::create([
            'user_id'    => Auth::user()->id,
            'product_id' => $product->id,
            'quantity'   => 1,
            'total'      => $product->price * 1,
            'status'     => 'pending',
        ]);

        $payload = [
            'transaction_details' => [
                'order_id'     => $transaction->id,
                'gross_amount' => $transaction->total,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email'      => Auth::user()->email,
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $transaction = Transaction::find($id);

        $transaction->update([
            'status' => $request->status,
        ]);

        $product = Product::find($transaction->product_id);
        $product->update([
            'stock' => $product->stock - $request->quantity,
        ]);

        return response()->json('success', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
