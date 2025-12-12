@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Order Details</h1>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Back</a>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Order Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Order Number:</strong> {{ $order->order_number }}</p>
                    <p><strong>Customer:</strong> 
    @if($order->customer)
        <a href="{{ route('customers.show', $order->customer) }}">{{ $order->customer->name }}</a>
    @else
        <span class="text-muted">Deleted Customer</span>
    @endif
</p>
                    <p><strong>Order Date:</strong> {{ $order->order_date->format('Y-m-d') }}</p>
                    <p><strong>Status:</strong> 
                        @if($order->status == 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @elseif($order->status == 'loaded')
                            <span class="badge bg-info">Loaded</span>
                        @elseif($order->status == 'delivered')
                            <span class="badge bg-primary">Delivered</span>
                        @else
                            <span class="badge bg-success">Completed</span>
                        @endif
                    </p>
                    <p><strong>Urgent:</strong> 
                        @if($order->is_urgent)
                            <span class="badge bg-danger">Yes</span>
                        @else
                            <span class="badge bg-secondary">No</span>
                        @endif
                    </p>
                    <p><strong>Total Amount:</strong> Rs. {{ number_format($order->total_amount, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Delivery Information</h5>
                </div>
                <div class="card-body">
                    @if($order->deliveryRoute)
                        <p><strong>Route Name:</strong> {{ $order->deliveryRoute->route_name }}</p>
                        <p><strong>Driver:</strong> {{ $order->deliveryRoute->driver_name }}</p>
                        <p><strong>Assistant:</strong> {{ $order->deliveryRoute->assistant_name ?? 'N/A' }}</p>
                        <p><strong>Route Date:</strong> {{ $order->deliveryRoute->route_date->format('Y-m-d') }}</p>
                        <a href="{{ route('delivery-routes.show', $order->deliveryRoute) }}" class="btn btn-sm btn-info">View Route</a>
                    @else
                        <p class="text-muted">No delivery route assigned yet</p>
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
                        <th>Price</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->gas_type }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>Rs. {{ number_format($item->price, 2) }}</td>
                            <td>Rs. {{ number_format($item->amount, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total:</th>
                        <th>Rs. {{ number_format($order->total_amount, 2) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    @if($order->status != 'completed')
        <div class="card">
            <div class="card-header">
                <h5>Update Order Status</h5>
            </div>
            <div class="card-body">
                <div class="btn-group">
                    @if($order->status == 'pending')
                        <form action="{{ route('orders.update-status', $order) }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="status" value="loaded">
                            <button type="submit" class="btn btn-info" onclick="return confirm('Mark as Loaded?')">Mark as Loaded</button>
                        </form>
                    @endif
                    @if($order->status == 'loaded')
                        <form action="{{ route('orders.update-status', $order) }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="status" value="delivered">
                            <button type="submit" class="btn btn-primary" onclick="return confirm('Mark as Delivered?')">Mark as Delivered</button>
                        </form>
                    @endif
                    @if($order->status == 'delivered')
                        <form action="{{ route('orders.update-status', $order) }}" method="POST" class="d-inline">
                            @csrf
                            <input type="hidden" name="status" value="completed">
                            <button type="submit" class="btn btn-success" onclick="return confirm('Mark as Completed?')">Mark as Completed</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
@endsection