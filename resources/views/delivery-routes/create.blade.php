@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Create Delivery Route</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('delivery-routes.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="route_name" class="form-label">Route Name</label>
                        <input type="text" class="form-control @error('route_name') is-invalid @enderror" 
                               id="route_name" name="route_name" value="{{ old('route_name') }}" required>
                        @error('route_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="route_date" class="form-label">Route Date</label>
                        <input type="date" class="form-control @error('route_date') is-invalid @enderror" 
                               id="route_date" name="route_date" value="{{ old('route_date', date('Y-m-d')) }}" required>
                        @error('route_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="driver_name" class="form-label">Driver Name</label>
                        <input type="text" class="form-control @error('driver_name') is-invalid @enderror" 
                               id="driver_name" name="driver_name" value="{{ old('driver_name') }}" required>
                        @error('driver_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="assistant_name" class="form-label">Assistant Name</label>
                        <input type="text" class="form-control @error('assistant_name') is-invalid @enderror" 
                               id="assistant_name" name="assistant_name" value="{{ old('assistant_name') }}">
                        @error('assistant_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="planned_start_time" class="form-label">Planned Start Time</label>
                        <input type="time" class="form-control @error('planned_start_time') is-invalid @enderror" 
                               id="planned_start_time" name="planned_start_time" value="{{ old('planned_start_time') }}">
                        @error('planned_start_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="planned_end_time" class="form-label">Planned End Time</label>
                        <input type="time" class="form-control @error('planned_end_time') is-invalid @enderror" 
                               id="planned_end_time" name="planned_end_time" value="{{ old('planned_end_time') }}">
                        @error('planned_end_time')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Create Route</button>
                    <a href="{{ route('delivery-routes.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection