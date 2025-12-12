@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Customer Details</h1>
        <div>
            <a href="{{ route('customers.edit', $customer) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('customers.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5>Basic Information</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Name:</strong> {{ $customer->name }}</p>
                    <p><strong>Type:</strong> <span class="badge bg-info">{{ ucfirst($customer->type) }}</span></p>
<p><strong>Contact:</strong> {{ $customer->contact ?? 'N/A' }}</p>
<p><strong>Address:</strong> {{ $customer->address ?? 'N/A' }}</p>
</div>
<div class="col-md-6">
<p><strong>Credit Limit:</strong> Rs. {{ number_format($customer->credit_limit, 2) }}</p>
<p><strong>Current Balance:</strong>
@if($customer->balance > 0)
<span class="text-danger">Rs. {{ number_format($customer->balance, 2) }}</span>
@else
<span class="text-success">Rs. 0.00</span>
@endif
</p>
<p><strong>Price 2.8kg:</strong> Rs. {{ number_format($customer->price_2_8kg ?? 0, 2) }}</p>
<p><strong>Price 5kg:</strong> Rs. {{ number_format($customer->price_5kg ?? 0, 2) }}</p>
<p><strong>Price 12.5kg:</strong> Rs. {{ number_format($customer->price_12_5kg ?? 0, 2) }}</p>
</div>
</div>
</div>
</div>
<div class="card">
    <div class="card-header">
        <h5>Orders</h5>
    </div>
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Order Number</th>
                    <th>Date</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customer->orders as $order)
                    <tr>
                        <td>{{ $order->order_number }}</td>
                        <td>{{ $order->order_date->format('Y-m-d') }}</td>
                        <td>Rs. {{ number_format($order->total_amount, 2) }}</td>
                        <td><span class="badge bg-secondary">{{ $order->status }}</span></td>
                        <td>
                            <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-info">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No orders found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
</div>
@endsection
