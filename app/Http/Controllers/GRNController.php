<?php

namespace App\Http\Controllers;

use App\Models\GRN;
use App\Models\GRNItem;
use App\Models\PurchaseOrder;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GRNController extends Controller
{
    public function index()
    {
        $grns = GRN::with('purchaseOrder', 'supplier')->latest()->get();
        return view('grns.index', compact('grns'));
    }

    public function create()
    {
        $purchaseOrders = PurchaseOrder::where('status', 'approved')->get();
        return view('grns.create', compact('purchaseOrders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'purchase_order_id' => 'required|exists:purchase_orders,id',
            'received_date' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.received_qty' => 'required|integer|min:0',
            'items.*.damaged' => 'nullable|integer|min:0',
        ]);

        DB::beginTransaction();
        try {
            $po = PurchaseOrder::with('items')->find($request->purchase_order_id);

            // Generate GRN Number
            $lastGRN = GRN::latest('id')->first();
            $grnNumber = 'GRN-' . date('Ymd') . '-' . str_pad(($lastGRN ? $lastGRN->id + 1 : 1), 4, '0', STR_PAD_LEFT);

            // Create GRN
            $grn = GRN::create([
                'purchase_order_id' => $request->purchase_order_id,
                'supplier_id' => $po->supplier_id,
                'grn_number' => $grnNumber,
                'received_date' => $request->received_date,
                'status' => 'pending',
                'remarks' => $request->remarks,
            ]);

            // Create GRN Items
            foreach ($request->items as $index => $item) {
                $poItem = $po->items[$index];
                $damaged = $item['damaged'] ?? 0;
                $shortSupply = $poItem->quantity - $item['received_qty'] - $damaged;

                GRNItem::create([
                    'grn_id' => $grn->id,
                    'gas_type' => $poItem->gas_type,
                    'ordered_qty' => $poItem->quantity,
                    'received_qty' => $item['received_qty'],
                    'short_supply' => max(0, $shortSupply),
                    'damaged' => $damaged,
                ]);
            }

            DB::commit();
            return redirect()->route('grns.index')->with('success', 'GRN created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error creating GRN: ' . $e->getMessage());
        }
    }

    public function show(GRN $grn)
    {
        $grn->load('purchaseOrder', 'supplier', 'items');
        return view('grns.show', compact('grn'));
    }

    public function approve(GRN $grn)
    {
        DB::beginTransaction();
        try {
            // Update GRN status
            $grn->update(['status' => 'approved']);

            // Update stock
            foreach ($grn->items as $item) {
                $stock = Stock::firstOrCreate(
                    ['gas_type' => $item->gas_type],
                    ['quantity' => 0]
                );
                $stock->increment('quantity', $item->received_qty);
            }

            // Check if PO is fully received
            $po = $grn->purchaseOrder;
            $allApproved = $po->grns()->where('status', 'approved')->count() > 0;
            
            if ($allApproved) {
                $po->update(['status' => 'completed']);
            }

            DB::commit();
            return back()->with
            ('success', 'GRN approved and stock updated successfully.');
} catch (\Exception $e) {
DB::rollBack();
return back()->with('error', 'Error approving GRN: ' . $e->getMessage());
}
}
}