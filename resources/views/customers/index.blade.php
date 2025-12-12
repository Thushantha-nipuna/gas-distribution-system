@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Customers</h1>
        <div>
            <a href="{{ route('customers.trashed') }}" class="btn btn-warning">
                <i class="bi bi-trash"></i> View Deleted ({{ \App\Models\Customer::onlyTrashed()->count() }})
            </a>
            <a href="{{ route('customers.create') }}" class="btn btn-primary">Add Customer</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Contact</th>
                        <th>Credit Limit</th>
                        <th>Balance</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                        <tr>
                            <td>{{ $customer->id }}</td>
                            <td>{{ $customer->name }}</td>
                            <td>
                                <span class="badge bg-info">{{ ucfirst($customer->type) }}</span>
                            </td>
                            <td>{{ $customer->contact ?? 'N/A' }}</td>
                            <td>Rs. {{ number_format($customer->credit_limit, 2) }}</td>
                            <td>
                                @if($customer->balance > 0)
                                    <span class="text-danger">Rs. {{ number_format($customer->balance, 2) }}</span>
                                @else
                                    <span class="text-success">Rs. 0.00</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('customers.show', $customer) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('customers.edit', $customer) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('customers.destroy', $customer) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No customers found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection