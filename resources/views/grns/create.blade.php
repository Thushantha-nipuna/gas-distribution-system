@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Create GRN</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('grns.store') }}" method="POST" id="grnForm">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="purchase_order_id" class="form-label">Purchase Order</label>
                        <select class="form-select @error('purchase_order_id') is-invalid @enderror" 
                                id="purchase_order_id" name="purchase_order_id" required>
                            <option value="">Select Purchase Order</option>
                            @foreach($purchaseOrders as $po)
                                <option value="{{ $po->id }}" 
                                        data-items='@json($po->items)'
                                        {{ old('purchase_order_id') == $po->id ? 'selected' : '' }}>
                                    {{ $po->po_number }} - {{ $po->supplier->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('purchase_order_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="received_date" class="form-label">Received Date</label>
                        <input type="date" class="form-control @error('received_date') is-invalid @enderror" 
                               id="received_date" name="received_date" value="{{ old('received_date', date('Y-m-d')) }}" required>
                        @error('received_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="remarks" class="form-label">Remarks</label>
                    <textarea class="form-control" id="remarks" name="remarks" rows="2">{{ old('remarks') }}</textarea>
                </div>

                <hr>

                <h5 class="mb-3">Items Received</h5>
                <div id="items-container">
                    <!-- Items will be loaded dynamically -->
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">Create GRN</button>
                    <a href="{{ route('grns.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('purchase_order_id').addEventListener('change', function() {
        const selectedOption = this.selectedOptions[0];
        const items = JSON.parse(selectedOption.dataset.items || '[]');
        const container = document.getElementById('items-container');
        
        container.innerHTML = '';
        
        items.forEach((item, index) => {
            const itemHtml = `
                <div class="card mb-3">
                    <div class="card-body">
                        <h6>${item.gas_type}</h6>
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Ordered Qty</label>
                                <input type="number" class="form-control" value="${item.quantity}" readonly>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Received Qty</label>
                                <input type="number" class="form-control" name="items[${index}][received_qty]" 
                                       min="0" max="${item.quantity}" value="${item.quantity}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Damaged</label>
                                <input type="number" class="form-control" name="items[${index}][damaged]" 
                                       min="0" value="0">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Short Supply (Auto)</label>
                                <input type="text" class="form-control short-supply" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            container.insertAdjacentHTML('beforeend', itemHtml);
        });
        
        calculateShortages();
    });

    function calculateShortages() {
        document.querySelectorAll('.card').forEach((card, index) => {
            const orderedQty = parseInt(card.querySelector('input[readonly]').value) || 0;
            const receivedInput = card.querySelector(`input[name="items[${index}][received_qty]"]`);
            const damagedInput = card.querySelector(`input[name="items[${index}][damaged]"]`);
            const shortSupplyInput = card.querySelector('.short-supply');
            
            receivedInput.addEventListener('input', updateShortage);
            damagedInput.addEventListener('input', updateShortage);
            
            function updateShortage() {
                const received = parseInt(receivedInput.value) || 0;
                const damaged = parseInt(damagedInput.value) || 0;
                const shortage = orderedQty - received - damaged;
                shortSupplyInput.value = Math.max(0, shortage);
            }
        });
    }

    // Trigger change if there's a selected PO on page load
    if(document.getElementById('purchase_order_id').value) {
        document.getElementById('purchase_order_id').dispatchEvent(new Event('change'));
    }
</script>
@endpush
@endsection