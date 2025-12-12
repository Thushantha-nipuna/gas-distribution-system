<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderItem;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseOrderController extends Controller
{
    public function index()
    {
        $purchaseOrders = PurchaseOrder::with('supplier')->latest()->get();
        return view('purchase-orders.index', compact('purchaseOrders'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        return view('purchase-orders.create', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'order_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.gas_type' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            // Generate PO Number
            $lastPO = PurchaseOrder::latest('id')->first();
            $poNumber = 'PO-' . date('Ymd') . '-' . str_pad(($lastPO ? $lastPO->id + 1 : 1), 4, '0', STR_PAD_LEFT);

            $supplier = Supplier::find($request->supplier_id);
            $totalAmount = 0;

            // Create PO
            $po = PurchaseOrder::create([
                'supplier_id' => $request->supplier_id,
                'po_number' => $poNumber,
                'order_date' => $request->order_date,
                'status' => 'pending',
                'total_amount' => 0,
            ]);

            // Create PO Items
            foreach ($request->items as $item) {
                $rate = 0;
                if ($item['gas_type'] == '2.8kg') {
                    $rate = $supplier->rate_2_8kg;
                } elseif ($item['gas_type'] == '5kg') {
                    $rate = $supplier->rate_5kg;
                } elseif ($item['gas_type'] == '12.5kg') {
                    $rate = $supplier->rate_12_5kg;
                }

                $amount = $rate * $item['quantity'];
                $totalAmount += $amount;

                PurchaseOrderItem::create([
                    'purchase_order_id' => $po->id,
                    'gas_type' => $item['gas_type'],
                    'quantity' => $item['quantity'],
                    'rate' => $rate,
                    'amount' => $amount,
                ]);
            }

            // Update total amount
            $po->update(['total_amount' => $totalAmount]);

            DB::commit();
            return redirect()->route('purchase-orders.index')->with('success', 'Purchase Order created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error creating Purchase Order: ' . $e->getMessage());
        }
    }

    public function show(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->load('supplier', 'items', 'payments', 'grns');
        return view('purchase-orders.show', compact('purchaseOrder'));
    }

    public function approve(PurchaseOrder $purchaseOrder)
    {
        $purchaseOrder->update(['status' => 'approved']);
        return back()->with('success', 'Purchase Order approved successfully.');
    }
}