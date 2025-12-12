@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Supplier</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('suppliers.update', $supplier) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-3">
                    <label for="name" class="form-label">Supplier Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name', $supplier->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="contact" class="form-label">Contact</label>
                    <input type="text" class="form-control @error('contact') is-invalid @enderror" 
                           id="contact" name="contact" value="{{ old('contact', $supplier->contact) }}">
                    @error('contact')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea class="form-control @error('address') is-invalid @enderror" 
                              id="address" name="address" rows="3">{{ old('address', $supplier->address) }}</textarea>
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="rate_2_8kg" class="form-label">Rate 2.8kg</label>
                        <input type="number" step="0.01" class="form-control @error('rate_2_8kg') is-invalid @enderror" 
                               id="rate_2_8kg" name="rate_2_8kg" value="{{ old('rate_2_8kg', $supplier->rate_2_8kg) }}" required>
                        @error('rate_2_8kg')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="rate_5kg" class="form-label">Rate 5kg</label>
                        <input type="number" step="0.01" class="form-control @error('rate_5kg') is-invalid @enderror" 
                               id="rate_5kg" name="rate_5kg" value="{{ old('rate_5kg', $supplier->rate_5kg) }}" required>
                        @error('rate_5kg')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4 mb-3">
                        <label for="rate_12_5kg" class="form-label">Rate 12.5kg</label>
                        <input type="number" step="0.01" class="form-control @error('rate_12_5kg') is-invalid @enderror" 
                               id="rate_12_5kg" name="rate_12_5kg" value="{{ old('rate_12_5kg', $supplier->rate_12_5kg) }}" required>
                        @error('rate_12_5kg')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Update Supplier</button>
                    <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection