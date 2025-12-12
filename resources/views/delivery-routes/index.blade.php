@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Delivery Routes</h1>
        <a href="{{ route('delivery-routes.create') }}" class="btn btn-primary">Create Route</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Route Name</th>
                        <th>Driver</th>
                        <th>Assistant</th>
                        <th>Route Date</th>
                        <th>Orders</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($routes as $route)
                        <tr>
                            <td>{{ $route->route_name }}</td>
                            <td>{{ $route->driver_name }}</td>
                            <td>{{ $route->assistant_name ?? 'N/A' }}</td>
                            <td>{{ $route->route_date->format('Y-m-d') }}</td>
                            <td>
                                <span class="badge bg-primary">{{ $route->orders->count() }} Orders</span>
                            </td>
                            <td>
                                <a href="{{ route('delivery-routes.show', $route) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('delivery-routes.edit', $route) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('delivery-routes.destroy', $route) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No delivery routes found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection