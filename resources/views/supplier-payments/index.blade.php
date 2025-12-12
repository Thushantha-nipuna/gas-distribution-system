@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Supplier Payments</h1>
        <a href="{{ route('supplier-payments.create') }}" class="btn btn-primary">Record Payment</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Payment Date</th>
                        <th>Supplier</th>
                        <th>PO Number</th>
                        <th>Amount</th>
                        <th>Payment Mode</th>
                        <th>Cheque Number</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td>{{ $payment->payment_date->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('supplier-payments.ledger', $payment->supplier) }}">
                                    {{ $payment->supplier->name }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('purchase-orders.show', $payment->purchaseOrder) }}">
                                    {{ $payment->purchaseOrder->po_number }}
                                </a>
                            </td>
                            <td>Rs. {{ number_format($payment->amount, 2) }}</td>
                            <td>{{ ucfirst($payment->payment_mode) }}</td>
                            <td>{{ $payment->cheque_number ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('supplier-payments.show', $payment) }}" class="btn btn-sm btn-info">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No payments found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection