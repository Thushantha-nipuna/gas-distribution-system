@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Supplier Ledger: {{ $supplier->name }}</h1>
        <a href="{{ route('supplier-payments.index') }}" class="btn btn-secondary">Back</a>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5>Supplier Information</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Name:</strong> {{ $supplier->name }}</p>
                    <p><strong>Contact:</strong> {{ $supplier->contact ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Total PO Value:</strong> Rs. {{ number_format($purchaseOrders->sum('total_amount'), 2) }}</p>
                    <p><strong>Total Paid:</strong> Rs. {{ number_format($purchaseOrders->sum(fn($po) => $po->totalPaid()), 2) }}</p>
                    <p><strong>Total Outstanding:</strong> 
                        <span class="text-danger fw-bold">
                            Rs. {{ number_format($purchaseOrders->sum(fn($po) => $po->balanceDue()), 2) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Purchase Orders & Payments</h5>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>PO Number</th>
                        <th>PO Date</th>
                        <th>Total Amount</th>
                        <th>Paid Amount</th>
                        <th>Balance Due</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($purchaseOrders as $po)
                        <tr>
                            <td>
                                <a href="{{ route('purchase-orders.show', $po) }}">{{ $po->po_number }}</a>
                            </td>
                            <td>{{ $po->order_date->format('Y-m-d') }}</td>
                            <td>Rs. {{ number_format($po->total_amount, 2) }}</td>
                            <td>Rs. {{ number_format($po->totalPaid(), 2) }}</td>
                            <td>
                                @if($po->balanceDue() > 0)
                                    <span class="text-danger">Rs. {{ number_format($po->balanceDue(), 2) }}</span>
                                @else
                                    <span class="text-success">Paid</span>
                                @endif
                            </td>
                            <td><span class="badge bg-secondary">{{ $po->status }}</span></td>
                        </tr>
                        @if($po->payments->count() > 0)
                            <tr>
                                <td colspan="6">
                                    <small class="text-muted">Payments:</small>
                                    <ul class="list-unstyled mb-0">
                                        @foreach($po->payments as $payment)
                                            <li class="ms-3">
                                                <small>
                                                    {{ $payment->payment_date->format('Y-m-d') }} - 
                                                    Rs. {{ number_format($payment->amount, 2) }} 
                                                    ({{ $payment->payment_mode }})
                                                </small>
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No purchase orders found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection