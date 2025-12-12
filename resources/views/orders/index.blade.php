@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Customer Orders</h1>
        <a href="{{ route('orders.create') }}" class="btn btn-primary">Create Order</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Order Number</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Total Amount</th>
                        <th>Route</th>
                        <th>Status</th>
                        <th>Urgent</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>{{ $order->order_number }}</td>
                            <td>{{ $order->customer ? $order->customer->name : 'Deleted Customer' }}</td>
                            <td>{{ $order->order_date->format('Y-m-d') }}</td>
                            <td>Rs. {{ number_format($order->total_amount, 2) }}</td>
                            <td>{{ $order->deliveryRoute ? $order->deliveryRoute->route_name : 'Not Assigned' }}</td>
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
                                @if($order->status != 'completed')
                                    <div class="btn-group btn-group-sm">
                                        <button type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                            Update Status
                                        </button>
                                        <ul class="dropdown-menu">
                                            @if($order->status == 'pending')
                                                <li>
                                                    <form action="{{ route('orders.update-status', $order) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="loaded">
                                                        <button type="submit" class="dropdown-item">Mark as Loaded</button>
                                                    </form>
                                                </li>
                                            @endif
                                            @if($order->status == 'loaded')
                                                <li>
                                                    <form action="{{ route('orders.update-status', $order) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="delivered">
                                                        <button type="submit" class="dropdown-item">Mark as Delivered</button>
                                                    </form>
                                                </li>
                                            @endif
                                            @if($order->status == 'delivered')
                                                <li>
                                                    <form action="{{ route('orders.update-status', $order) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="status" value="completed">
                                                        <button type="submit" class="dropdown-item">Mark as Completed</button>
                                                    </form>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center">No orders found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection