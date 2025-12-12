@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Create Purchase Order</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('purchase-orders.store') }}" method="POST" id="poForm">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="supplier_id" class="form-label">Supplier</label>
                        <select class="form-select @error('supplier_id') is-invalid @enderror" 
                                id="supplier_id" name="supplier_id" required>
                            <option value="">Select Supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" 
                                        data-rate-2-8="{{ $supplier->rate_2_8kg }}"
                                        data-rate-5="{{ $supplier->rate_5kg }}"
                                        data-rate-12-5="{{ $supplier->rate_12_5kg }}"
                                        {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="order_date" class="form-label">Order Date</label>
                        <input type="date" class="form-control @error('order_date') is-invalid @enderror" 
                               id="order_date" name="order_date" value="{{ old('order_date', date('Y-m-d')) }}" required>
                        @error('order_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr>

                <h5 class="mb-3">Order Items</h5>
                <div id="items-container">
                    <div class="row item-row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Gas Type</label>
                            <select class="form-select gas-type" name="items[0][gas_type]" required>
                                <option value="">Select Type</option>
                                <option value="2.8kg">2.8kg</option>
                                <option value="5kg">5kg</option>
                                <option value="12.5kg">12.5kg</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" class="form-control quantity" name="items[0][quantity]" min="1" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Rate (Auto)</label>
                            <input type="text" class="form-control rate" readonly>
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">&nbsp;</label>
                            <button type="button" class="btn btn-danger w-100 remove-item">Remove</button>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-secondary mb-3" id="add-item">Add Item</button>

                <hr>

                <div class="mb-3">
                    <h5>Total Amount: <span id="total-amount">Rs. 0.00</span></h5>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Create Purchase Order</button>
                    <a href="{{ route('purchase-orders.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let itemIndex = 1;
    
    document.getElementById('add-item').addEventListener('click', function() {
        const container = document.getElementById('items-container');
        const newItem = `
            <div class="row item-row mb-3">
                <div class="col-md-4">
                    <label class="form-label">Gas Type</label>
                    <select class="form-select gas-type" name="items[${itemIndex}][gas_type]" required>
                        <option value="">Select Type</option>
                        <option value="2.8kg">2.8kg</option>
                        <option value="5kg">5kg</option>
                        <option value="12.5kg">12.5kg</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Quantity</label>
                    <input type="number" class="form-control quantity" name="items[${itemIndex}][quantity]" min="1" required>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Rate (Auto)</label>
                    <input type="text" class="form-control rate" readonly>
                </div>
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <button type="button" class="btn btn-danger w-100 remove-item">Remove</button>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', newItem);
        itemIndex++;
        attachEventListeners();
    });

    function attachEventListeners() {
        document.querySelectorAll('.remove-item').forEach(btn => {
            btn.addEventListener('click', function() {
                if(document.querySelectorAll('.item-row').length > 1) {
                    this.closest('.item-row').remove();
                    calculateTotal();
                }
            });
        });

        document.querySelectorAll('.gas-type, .quantity').forEach(input => {
            input.addEventListener('change', calculateTotal);
        });
    }

    function calculateTotal() {
        const supplier = document.getElementById('supplier_id').selectedOptions[0];
        let total = 0;

        document.querySelectorAll('.item-row').forEach(row => {
            const gasType = row.querySelector('.gas-type').value;
            const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
            let rate = 0;

            if(gasType && supplier) {
                if(gasType === '2.8kg') rate = parseFloat(supplier.dataset.rate28) || 0;
                if(gasType === '5kg') rate = parseFloat(supplier.dataset.rate5) || 0;
                if(gasType === '12.5kg') rate = parseFloat(supplier.dataset.rate125) || 0;
            }

            row.querySelector('.rate').value = 'Rs. ' + rate.toFixed(2);
            total += rate * quantity;
        });

        document.getElementById('total-amount').textContent = 'Rs. ' + total.toFixed(2);
    }

    document.getElementById('supplier_id').addEventListener('change', calculateTotal);
    attachEventListeners();
</script>
@endpush
@endsection