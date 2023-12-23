<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
use Inertia\Inertia;
use App\Models\Customer;
use App\Models\Item;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Order;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = Order::searchCustomers($request->customerName)->betweenDate($request->startDate, $request->endDate)->groupBy('id')
            ->selectRaw('id, customer_name, sum(subtotal) as total, status, created_at')
            ->paginate(50);
        return Inertia::render('Purchases/Index', [
            'orders' => $orders,
            'customerName' => $request->customerName,
            'startDate' => $request->startDate,
            'endDate' => $request->endDate
        ]);
    }

    /**
     * 条件で絞り込み
     * @return \Illuminate\Http\JsonResponse
     */
    public function search(Request $request)
    {
        $orders = Order::searchCustomers($request->customerName)->betweenDate($request->startDate, $request->endDate)->groupBy('id')
            ->selectRaw('id, customer_name, sum(subtotal) as total, status, created_at')
            ->paginate(50);
        return response()->json($orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::select('id', 'name', 'kana')->get();
        $items = Item::select('id', 'name', 'price')
            ->where('is_selling', true)
            ->get();
        return Inertia::render('Purchases/Create', [
            'customers' => $customers,
            'items' => $items
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePurchaseRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePurchaseRequest $request)
    {

        DB::transaction(function () use ($request) {
            $purchase = Purchase::create([
                'customer_id' => $request->customer_id,
                'status' => $request->status,
            ]);
            foreach ($request->items as $item) {
                $purchase->items()->attach($item['id'], [
                    'quantity' => $item['quantity']
                ]);
            }
        });

        return to_route('dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        // 小計
        $items = Order::where('id', $purchase->id)->get();
        // 合計
        $order = Order::groupBy('id')
            ->where('id', $purchase->id)
            ->selectRaw('id, customer_name, sum(subtotal) as total, status, created_at, updated_at')->get();
        return Inertia::render('Purchases/Show', [
            'items' => $items, 'order' => $order
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        $allItems = Item::select('id', 'name', 'price')->get(); // 全商品を取得
        $items = []; // 空の配列を用意

        // 販売中の商品と中間テーブルを比較し、中間テーブルに数量があれば数量を取得、なければ0で設定
        foreach ($allItems as $allItem) {
            $quantity = 0; // 数量初期値 0
            foreach ($purchase->items as $item) { // 中間テーブルを1件ずつチェック
                if ($allItem->id === $item->id) { // 同じidがあれば
                    $quantity = $item->pivot->quantity; // 中間テーブルの数量を設定 
                }
            }
            array_push($items, [
                'id' => $allItem->id, 'name' => $allItem->name,
                'price' => $allItem->price, 'quantity' => $quantity
            ]);
        }

        $order = Order::groupBy('id')
            ->where('id', $purchase->id)
            ->selectRaw('id, customer_id, customer_name, status, created_at')
            ->get();
        return Inertia::render('Purchases/Edit', [
            'items' => $items,
            'order' => $order
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePurchaseRequest  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePurchaseRequest $request, Purchase $purchase)
    {
        DB::transaction(function () use ($request, $purchase) {
            $purchase->status = $request->status;
            $purchase->created_at = $request->date;
            $purchase->save();

            $items = [];
            foreach ($request->items as $item) {

                // item_id => [ 中間テーブルの列名 => 値 ]
                $items[$item['id']] = ['quantity' => $item['quantity']];
            }
            $purchase->items()->sync($items);
        });

        return to_route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        //
    }
}
