@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Goods Received Notes (GRN)</h1>
        <a href="{{ route('grns.create') }}" class="btn btn-primary">Create GRN</a>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>GRN Number</th>
                        <th>PO Number</th>
                        <th>Supplier</th>
                        <th>Received Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($grns as $grn)
                        <tr>
                            <td>{{ $grn->grn_number }}</td>
                            <td>{{ $grn->purchaseOrder->po_number }}</td>
                            <td>{{ $grn->supplier->name }}</td>
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
                                @if($grn->status == 'pending')
                                    <form action="{{ route('grns.approve', $grn) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Approve this GRN and update stock?')">Approve</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No GRNs found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection