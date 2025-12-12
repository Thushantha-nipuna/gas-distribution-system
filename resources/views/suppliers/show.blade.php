@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Supplier Details</h1>
        <div>
            <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5>Basic Information</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Name:</strong> {{ $supplier->name }}</p>
                    <p><strong>Contact:</strong> {{ $supplier->contact ?? 'N/A' }}</p>
                    <p><strong>Address:</strong> {{ $supplier->address ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Rate 2.8kg:</strong> Rs. {{ number_format($supplier->rate_2_8kg, 2) }}</p>
                    <p><strong>Rate 5kg:</strong> Rs. {{ number_format($supplier->rate_5kg, 2) }}</p>
                    <p><strong>Rate 12.5kg:</strong> Rs. {{ number_format($supplier->rate_12_5kg, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Purchase Orders</h5>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>PO Number</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Total Amount</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($supplier->purchaseOrders as $po)
                        <tr>
                            <td>{{ $po->po_number }}</td>
                            <td>{{ $po->order_date->format('Y-m-d') }}</td>
                            <td><span class="badge bg-secondary">{{ $po->status }}</span></td>
                            <td>Rs. {{ number_format($po->total_amount, 2) }}</td>
                            <td>
                                <a href="{{ route('purchase-orders.show', $po) }}" class="btn btn-sm btn-info">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No purchase orders found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection