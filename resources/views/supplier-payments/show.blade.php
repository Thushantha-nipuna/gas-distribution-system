@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Payment Details</h1>
        <a href="{{ route('supplier-payments.index') }}" class="btn btn-secondary">Back</a>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Payment Information</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Supplier:</strong> 
                        <a href="{{ route('suppliers.show', $supplierPayment->supplier) }}">
                            {{ $supplierPayment->supplier->name }}
                        </a>
                    </p>
                    <p><strong>Purchase Order:</strong> 
                        <a href="{{ route('purchase-orders.show', $supplierPayment->purchaseOrder) }}">
                            {{ $supplierPayment->purchaseOrder->po_number }}
                        </a>
                    </p>
                    <p><strong>Payment Date:</strong> {{ $supplierPayment->payment_date->format('Y-m-d') }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Amount:</strong> Rs. {{ number_format($supplierPayment->amount, 2) }}</p>
                    <p><strong>Payment Mode:</strong> {{ ucfirst($supplierPayment->payment_mode) }}</p>
                    <p><strong>Cheque Number:</strong> {{ $supplierPayment->cheque_number ?? 'N/A' }}</p>
                </div>
            </div>
            @if($supplierPayment->remarks)
                <hr>
                <p><strong>Remarks:</strong> {{ $supplierPayment->remarks }}</p>
            @endif
        </div>
    </div>
</div>
@endsection