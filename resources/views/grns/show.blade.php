@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>GRN Details</h1>
        <div>
            @if($grn->status == 'pending')
                <form action="{{ route('grns.approve', $grn) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success" onclick="return confirm('Approve this GRN and update stock?')">Approve GRN</button>
                </form>
            @endif
            <a href="{{ route('grns.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5>GRN Information</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>GRN Number:</strong> {{ $grn->grn_number }}</p>
                    <p><strong>PO Number:</strong> 
                        <a href="{{ route('purchase-orders.show', $grn->purchaseOrder) }}">{{ $grn->purchaseOrder->po_number }}</a>
                    </p>
                    <p><strong>Supplier:</strong> {{ $grn->supplier->name }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Received Date:</strong> {{ $grn->received_date->format('Y-m-d') }}</p>
                    <p><strong>Status:</strong> 
                        @if($grn->status == 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @else
                            <span class="badge bg-success">Approved</span>
                        @endif
                    </p>
                    <p><strong>Remarks:</strong> {{ $grn->remarks ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Items Received</h5>
        </div>
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Gas Type</th>
                        <th>Ordered Qty</th>
                        <th>Received Qty</th>
                        <th>Short Supply</th>
                        <th>Damaged</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($grn->items as $item)
                        <tr>
                            <td>{{ $item->gas_type }}</td>
                            <td>{{ $item->ordered_qty }}</td>
                            <td>{{ $item->received_qty }}</td>
                            <td>
                                @if($item->short_supply > 0)
                                    <span class="badge bg-warning">{{ $item->short_supply }}</span>
                                @else
                                    <span class="badge bg-success">0</span>
                                @endif
                            </td>
                            <td>
                                @if($item->damaged > 0)
                                    <span class="badge bg-danger">{{ $item->damaged }}</span>
                                @else
                                    <span class="badge bg-success">0</span>
                                @endif
                            </td>
                            <td>
                                @if($item->received_qty == $item->ordered_qty)
                                    <span class="badge bg-success">Complete</span>
                                @else
                                    <span class="badge bg-warning">Partial</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection