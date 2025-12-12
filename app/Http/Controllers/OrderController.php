<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Models\DeliveryRoute;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
{
    $orders = Order::with(['customer', 'deliveryRoute'])->latest()->get();
    return view('orders.index', compact('orders'));
}

    public function create()
    {
        $customers = Customer::all();
        $routes = DeliveryRoute::all();
        return view('orders.create', compact('customers', 'routes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'delivery_route_id' => 'nullable|exists:delivery_routes,id',
            'order_date' => 'required|date',
            'is_urgent' => 'nullable|boolean',
            'items' => 'required|array|min:1',
            'items.*.gas_type' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $customer = Customer::find($request->customer_id);

            // Generate Order Number
            $lastOrder = Order::latest('id')->first();
            $orderNumber = 'ORD-' . date('Ymd') . '-' . str_pad(($lastOrder ? $lastOrder->id + 1 : 1), 4, '0', STR_PAD_LEFT);

            $totalAmount = 0;

            // Create Order
            $order = Order::create([
                'customer_id' => $request->customer_id,
                'delivery_route_id' => $request->delivery_route_id,
                'order_number' => $orderNumber,
                'order_date' => $request->order_date,
                'is_urgent' => $request->is_urgent ?? false,
                'status' => 'pending',
                'total_amount' => 0,
            ]);

            // Create Order Items
            foreach ($request->items as $item) {
                $price = 0;
                if ($item['gas_type'] == '2.8kg') {
                    $price = $customer->price_2_8kg ?? 0;
                } elseif ($item['gas_type'] == '5kg') {
                    $price = $customer->price_5kg ?? 0;
                } elseif ($item['gas_type'] == '12.5kg') {
                    $price = $customer->price_12_5kg ?? 0;
                }

                $amount = $price * $item['quantity'];
                $totalAmount += $amount;

                OrderItem::create([
                    'order_id' => $order->id,
                    'gas_type' => $item['gas_type'],
                    'quantity' => $item['quantity'],
                    'price' => $price,
                    'amount' => $amount,
                ]);
            }

            // Update total amount
            $order->update(['total_amount' => $totalAmount]);

            DB::commit();
            return redirect()->route('orders.index')->with('success', 'Order created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error creating Order: ' . $e->getMessage());
        }
    }

    public function show(Order $order)
    {
        $order->load('customer', 'deliveryRoute', 'items');
        return view('orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,loaded,delivered,completed',
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Order status updated successfully.');
    }
}