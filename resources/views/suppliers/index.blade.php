@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Suppliers</h1>
        <div>
            <a href="{{ route('suppliers.trashed') }}" class="btn btn-warning">
                <i class="bi bi-trash"></i> View Deleted ({{ \App\Models\Supplier::onlyTrashed()->count() }})
            </a>
            <a href="{{ route('suppliers.create') }}" class="btn btn-primary">Add Supplier</a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Contact</th>
                        <th>Rate 2.8kg</th>
                        <th>Rate 5kg</th>
                        <th>Rate 12.5kg</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($suppliers as $supplier)
                        <tr>
                            <td>{{ $supplier->id }}</td>
                            <td>{{ $supplier->name }}</td>
                            <td>{{ $supplier->contact }}</td>
                            <td>Rs. {{ number_format($supplier->rate_2_8kg, 2) }}</td>
                            <td>Rs. {{ number_format($supplier->rate_5kg, 2) }}</td>
                            <td>Rs. {{ number_format($supplier->rate_12_5kg, 2) }}</td>
                            <td>
                                <a href="{{ route('suppliers.show', $supplier) }}" class="btn btn-sm btn-info">View</a>
                                <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No suppliers found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection