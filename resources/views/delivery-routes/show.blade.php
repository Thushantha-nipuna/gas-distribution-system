@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Delivery Route Details</h1>
        <div>
            <a href="{{ route('delivery-routes.edit', $deliveryRoute) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('delivery-routes.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5>Route Information</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Route Name:</strong> {{ $deliveryRoute->route_name }}</p>
                    <p><strong>Driver:</strong> {{ $deliveryRoute->driver_name }}</p>
                    <p><strong>Assistant:</strong> {{ $deliveryRoute->assistant_name ?? 'N/A' }}</p>
                    <p><strong>Route Date:</strong> {{ $deliveryRoute->route_date->format('Y-m-d') }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Planned Start:</strong> {{ $deliveryRoute->planned_start_time ?? 'N/A' }}</p>
                    <p><strong>Planned End:</strong> {{ $deliveryRoute->planned_end_time ?? 'N/A' }}</p>
                    <p><strong>Actual Start:</strong> {{ $deliveryRoute->actual_start_time ?? 'Not Started' }}</p>
                    <p><strong>Actual End:</strong> {{ $deliveryRoute->actual_end_time ?? 'Not Completed' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Orders on this Route</h5>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Order Number</th>
                        <th>Customer</th>
                        <th>Total Amount</th>
                        <th>Status</th>
                        <th>Urgent</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($deliveryRoute->orders as $order)
                        <tr>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->customer ? $order->customer->name : 'Deleted Customer' }}</td>
                            <td>Rs. {{ number_format($order->total_amount, 2) }}</td>
                            <td>
                                @if($order->status == 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($order->status == 'loaded')
                                    <span class="badge bg-info">Loaded</span>
                                @elseif($order->status == 'delivered')
                                    <span class="badge bg-primary">Delivered</span>
                                @else
                                    <span class="badge bg-success">Completed</span>
                                @endif
                            </td>
                            <td>
                                @if($order->is_urgent)
                                    <span class="badge bg-danger">Urgent</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('orders.show', $order) }}" class="btn btn-sm btn-info">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No orders assigned to this route</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection