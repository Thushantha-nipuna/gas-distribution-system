@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Purchase Order Details</h1>
        <div>
            @if($purchaseOrder->status == 'pending')
                <form action="{{ route('purchase-orders.approve', $purchaseOrder) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success" onclick="return confirm('Approve this PO?')">Approve PO</button>
                </form>
            @endif
            <a href="{{ route('purchase-orders.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>PO Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>PO Number:</strong> {{ $purchaseOrder->po_number }}</p>
                    <p><strong>Supplier:</strong> {{ $purchaseOrder->supplier->name }}</p>
                    <p><strong>Order Date:</strong> {{ $purchaseOrder->order_date->format('Y-m-d') }}</p>
                    <p><strong>Status:</strong> 
                        @if($purchaseOrder->status == 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @elseif($purchaseOrder->status == 'approved')
                            <span class="badge bg-info">Approved</span>
                        @else
                            <span class="badge bg-success">Completed</span>
                        @endif
                    </p>
                    <p><strong>Total Amount:</strong> Rs. {{ number_format($purchaseOrder->total_amount, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Payment Summary</h5>
                </div>
                <div class="card-body">
                    <p><strong>Total PO Value:</strong> Rs. {{ number_format($purchaseOrder->total_amount, 2) }}</p>
                    <p><strong>Total Paid:</strong> Rs. {{ number_format($purchaseOrder->totalPaid(), 2) }}</p>
                    <p><strong>Balance Due:</strong> Rs. {{ number_format($purchaseOrder->balanceDue(), 2) }}</p>
                    @if($purchaseOrder->balanceDue() > 0)
                        <a href="{{ route('supplier-payments.create', ['purchase_order_id' => $purchaseOrder->id]) }}" class="btn btn-primary btn-sm">Make Payment</a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5>Order Items</h5>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Gas Type</th>
                        <th>Quantity</th>
                        <th>Rate</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($purchaseOrder->items as $item)
                        <tr>
                            <td>{{ $item->gas_type }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rs. {{ number_format($item->rate, 2) }}</td>
                            <td>Rs. {{ number_format($item->amount, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total:</th>
                        <th>Rs. {{ number_format($purchaseOrder->total_amount, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5>Payments</h5>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Payment Date</th>
                        <th>Amount</th>
                        <th>Payment Mode</th>
                        <th>Cheque Number</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($purchaseOrder->payments as $payment)
                        <tr>
                            <td>{{ $payment->payment_date->format('Y-m-d') }}</td>
                            <td>Rs. {{ number_format($payment->amount, 2) }}</td>
                            <td>{{ $payment->payment_mode }}</td>
                            <td>{{ $payment->cheque_number ?? 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No payments yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>GRNs</h5>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>GRN Number</th>
                        <th>Received Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($purchaseOrder->grns as $grn)
                        <tr>
                            <td>{{ $grn->grn_number }}</td>
                            <td>{{ $grn->received_date->format('Y-m-d') }}</td>
                            <td>
                                @if($grn->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @else
                                    <span class="badge bg-success">Approved</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('grns.show', $grn) }}" class="btn btn-sm btn-info">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No GRNs yet</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if($purchaseOrder->status == 'approved')
                <a href="{{ route('grns.create', ['purchase_order_id' => $purchaseOrder->id]) }}" class="btn btn-primary">Create GRN</a>
            @endif
        </div>
    </div>
</div>
@endsection