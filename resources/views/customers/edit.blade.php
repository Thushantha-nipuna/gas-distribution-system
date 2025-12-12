@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Customer</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('customers.update', $customer) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Customer Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $customer->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="type" class="form-label">Customer Type</label>
                        <select class="form-select @error('type') is-invalid @enderror" 
                                id="type" name="type" required>
                            <option value="dealer" {{ old('type', $customer->type) == 'dealer' ? 'selected' : '' }}>Dealer</option>
                            <option value="commercial" {{ old('type', $customer->type) == 'commercial' ? 'selected' : '' }}>Commercial</option>
                            <option value="individual" {{ old('type', $customer->type) == 'individual' ? 'selected' : '' }}>Individual</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="contact" class="form-label">Contact</label>
                        <input type="text" class="form-control @error('contact') is-invalid @enderror" 
                               id="contact" name="contact" value="{{ old('contact', $customer->contact) }}">
                        @error('contact')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="credit_limit" class="form-label">Credit Limit</label>
                        <input type="number" step="0.01" class="form-control @error('credit_limit') is-invalid @enderror" 
                               id="credit_limit" name="credit_limit" value="{{ old('credit_limit', $customer->credit_limit) }}">
                        @error('credit_limit')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" 
                              id="address" name="address" rows="3">{{ old('address', $customer->address) }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <hr>
                <h5 class="mb-3">Custom Pricing (Optional)</h5>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="price_2_8kg" class="form-label">Price 2.8kg</label>
                        <input type="number" step="0.01" class="form-control @error('price_2_8kg') is-invalid @enderror" 
                               id="price_2_8kg" name="price_2_8kg" value="{{ old('price_2_8kg', $customer->price_2_8kg) }}">
                        @error('price_2_8kg')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="price_5kg" class="form-label">Price 5kg</label>
                        <input type="number" step="0.01" class="form-control @error('price_5kg') is-invalid @enderror" 
                               id="price_5kg" name="price_5kg" value="{{ old('price_5kg', $customer->price_5kg) }}">
                        @error('price_5kg')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="price_12_5kg" class="form-label">Price 12.5kg</label>
                        <input type="number" step="0.01" class="form-control @error('price_12_5kg') is-invalid @enderror" 
                               id="price_12_5kg" name="price_12_5kg" value="{{ old('price_12_5kg', $customer->price_12_5kg) }}">
                        @error('price_12_5kg')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Update Customer</button>
                    <a href="{{ route('customers.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection