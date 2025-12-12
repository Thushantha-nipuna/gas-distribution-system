@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Create Customer Order</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('orders.store') }}" method="POST" id="orderForm">
                @csrf
                
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="customer_id" class="form-label">Customer</label>
                        <select class="form-select @error('customer_id') is-invalid @enderror" 
                                id="customer_id" name="customer_id" required>
                            <option value="">Select Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" 
                                        data-price-2-8="{{ $customer->price_2_8kg }}"
                                        data-price-5="{{ $customer->price_5kg }}"
                                        data-price-12-5="{{ $customer->price_12_5kg }}"
                                        {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->name }} ({{ ucfirst($customer->type) }})
                                </option>
                            @endforeach
                        </select>
                        @error('customer_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="delivery_route_id" class="form-label">Delivery Route</label>
                        <select class="form-select @error('delivery_route_id') is-invalid @enderror" 
                                id="delivery_route_id" name="delivery_route_id">
                            <option value="">Not Assigned</option>
                            @foreach($routes as $route)
                                <option value="{{ $route->id }}" {{ old('delivery_route_id') == $route->id ? 'selected' : '' }}>
                                    {{ $route->route_name }} - {{ $route->route_date->format('Y-m-d') }}
                                </option>
                            @endforeach
                        </select>
                        @error('delivery_route_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="order_date" class="form-label">Order Date</label>
                        <input type="date" class="form-control @error('order_date') is-invalid @enderror" 
                               id="order_date" name="order_date" value="{{ old('order_date', date('Y-m-d')) }}" required>
                        @error('order_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="is_urgent" name="is_urgent" value="1" {{ old('is_urgent') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_urgent">
                            Mark as Urgent Order
                        </label>
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
                            <label class="form-label">Price (Auto)</label>
                            <input type="text" class="form-control price" readonly>
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
                    <button type="submit" class="btn btn-primary">Create Order</button>
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancel</a>
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
                    <label class="form-label">Price (Auto)</label>
                    <input type="text" class="form-control price" readonly>
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
        const customer = document.getElementById('customer_id').selectedOptions[0];
        let total = 0;

        document.querySelectorAll('.item-row').forEach(row => {
            const gasType = row.querySelector('.gas-type').value;
            const quantity = parseFloat(row.querySelector('.quantity').value) || 0;
            let price = 0;

            if(gasType && customer) {
                if(gasType === '2.8kg') price = parseFloat(customer.dataset.price28) || 0;
                if(gasType === '5kg') price = parseFloat(customer.dataset.price5) || 0;
                if(gasType === '12.5kg') price = parseFloat(customer.dataset.price125) || 0;
            }

            row.querySelector('.price').value = 'Rs. ' + price.toFixed(2);
            total += price * quantity;
        });

        document.getElementById('total-amount').textContent = 'Rs. ' + total.toFixed(2);
    }

    document.getElementById('customer_id').addEventListener('change', calculateTotal);
    attachEventListeners();
</script>
@endpush
@endsection