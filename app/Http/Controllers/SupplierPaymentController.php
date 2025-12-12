<?php

namespace App\Http\Controllers;

use App\Models\SupplierPayment;
use App\Models\Supplier;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;

class SupplierPaymentController extends Controller
{
    public function index()
    {
        $payments = SupplierPayment::with('supplier', 'purchaseOrder')->latest()->get();
        return view('supplier-payments.index', compact('payments'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        $purchaseOrders = PurchaseOrder::whereIn('status', ['approved', 'completed'])->get();
        return view('supplier-payments.create', compact('suppliers', 'purchaseOrders'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'purchase_order_id' => 'required|exists:purchase_orders,id',
            'amount' => 'required|numeric|min:0',
            'payment_mode' => 'required|string',
            'cheque_number' => 'nullable|string',
            'payment_date' => 'required|date',
        ]);

        SupplierPayment::create($request->all());

        return redirect()->route('supplier-payments.index')->with('success', 'Payment recorded successfully.');
    }

    public function show(SupplierPayment $supplierPayment)
    {
        return view('supplier-payments.show', compact('supplierPayment'));
    }

    public function ledger(Supplier $supplier)
    {
        $purchaseOrders = $supplier->purchaseOrders()->with('payments')->get();
        return view('supplier-payments.ledger', compact('supplier', 'purchaseOrders'));
    }
}