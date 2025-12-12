@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Record Supplier Payment</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('supplier-payments.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="supplier_id" class="form-label">Supplier</label>
                        <select class="form-select @error('supplier_id') is-invalid @enderror" 
                                id="supplier_id" name="supplier_id" required>
                            <option value="">Select Supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('supplier_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="purchase_order_id" class="form-label">Purchase Order</label>
                        <select class="form-select @error('purchase_order_id') is-invalid @enderror" 
                                id="purchase_order_id" name="purchase_order_id" required>
                            <option value="">Select Purchase Order</option>
                            @foreach($purchaseOrders as $po)
                                <option value="{{ $po->id }}" 
                                        data-supplier="{{ $po->supplier_id }}"
                                        data-amount="{{ $po->total_amount }}"
                                        data-paid="{{ $po->totalPaid() }}"
                                        data-balance="{{ $po->balanceDue() }}"
                                        {{ old('purchase_order_id') == $po->id ? 'selected' : '' }}>
                                    {{ $po->po_number }} - Rs. {{ number_format($po->balanceDue(), 2) }} Due
                                </option>
                            @endforeach
                        </select>
                        @error('purchase_order_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="alert alert-info" id="po-details" style="display: none;">
                    <strong>PO Details:</strong><br>
                    Total Amount: <span id="po-total">Rs. 0.00</span><br>
                    Paid Amount: <span id="po-paid">Rs. 0.00</span><br>
                    Balance Due: <span id="po-balance">Rs. 0.00</span>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="amount" class="form-label">Payment Amount</label>
                        <input type="number" step="0.01" class="form-control @error('amount') is-invalid @enderror" 
                               id="amount" name="amount" value="{{ old('amount') }}" required>
                        @error('amount')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="payment_mode" class="form-label">Payment Mode</label>
                        <select class="form-select @error('payment_mode') is-invalid @enderror" 
                                id="payment_mode" name="payment_mode" required>
                            <option value="cheque" {{ old('payment_mode') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                            <option value="bank_transfer" {{ old('payment_mode') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="cash" {{ old('payment_mode') == 'cash' ? 'selected' : '' }}>Cash</option>
                        </select>
                        @error('payment_mode')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="cheque_number" class="form-label">Cheque Number</label>
                        <input type="text" class="form-control @error('cheque_number') is-invalid @enderror" 
                               id="cheque_number" name="cheque_number" value="{{ old('cheque_number') }}">
                        @error('cheque_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="payment_date" class="form-label">Payment Date</label>
                    <input type="date" class="form-control @error('payment_date') is-invalid @enderror" 
                           id="payment_date" name="payment_date" value="{{ old('payment_date', date('Y-m-d')) }}" required>
                    @error('payment_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="remarks" class="form-label">Remarks</label>
                    <textarea class="form-control" id="remarks" name="remarks" rows="2">{{ old('remarks') }}</textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Record Payment</button>
                    <a href="{{ route('supplier-payments.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    const supplierSelect = document.getElementById('supplier_id');
    const poSelect = document.getElementById('purchase_order_id');
    const poDetails = document.getElementById('po-details');

    supplierSelect.addEventListener('change', function() {
        const supplierId = this.value;
        
        // Filter PO options by supplier
        Array.from(poSelect.options).forEach(option => {
            if(option.value === '') {
                option.style.display = 'block';
                return;
            }
            
            if(option.dataset.supplier === supplierId) {
                option.style.display = 'block';
            } else {
                option.style.display = 'none';
            }
        });
        
        poSelect.value = '';
        poDetails.style.display = 'none';
    });

    poSelect.addEventListener('change', function() {
        const selectedOption = this.selectedOptions[0];
        
        if(this.value) {
            const total = parseFloat(selectedOption.dataset.amount) || 0;
            const paid = parseFloat(selectedOption.dataset.paid) || 0;
            const balance = parseFloat(selectedOption.dataset.balance) || 0;
            
            document.getElementById('po-total').textContent = 'Rs. ' + total.toFixed(2);
            document.getElementById('po-paid').textContent = 'Rs. ' + paid.toFixed(2);
            document.getElementById('po-balance').textContent = 'Rs. ' + balance.toFixed(2);
            
            document.getElementById('amount').value = balance.toFixed(2);
            
            poDetails.style.display = 'block';
        } else {
            poDetails.style.display = 'none';
        }
    });
</script>
@endpush
@endsection