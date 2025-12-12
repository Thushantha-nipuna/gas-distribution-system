@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard</h1>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total Suppliers</h5>
                    <h2>{{ $totalSuppliers }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">Total Customers</h5>
                    <h2>{{ $totalCustomers }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Pending POs</h5>
                    <h2>{{ $pendingPOs }}</h2>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">Pending Orders</h5>
                    <h2>{{ $pendingOrders }}</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Stock Levels by Gas Type</h5>
                </div>
                <div class="card-body">
                    <canvas id="stockChart" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Purchase Order Status</h5>
                </div>
                <div class="card-body">
                    <canvas id="poStatusChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Customer Order Status</h5>
                </div>
                <div class="card-body">
                    <canvas id="orderStatusChart" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Customer Type Distribution</h5>
                </div>
                <div class="card-body">
                    <canvas id="customerTypeChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Stock Status</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Gas Type</th>
                                <th>Quantity</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($stock as $item)
                                <tr>
                                    <td>{{ $item->gas_type }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>
                                        @if($item->quantity > 50)
                                            <span class="badge bg-success">Good</span>
                                        @elseif($item->quantity > 20)
                                            <span class="badge bg-warning">Low</span>
                                        @else
                                            <span class="badge bg-danger">Critical</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center">No stock data available</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Recent Purchase Orders</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>PO Number</th>
                                <th>Supplier</th>
                                <th>Status</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentPOs as $po)
                                <tr>
                                    <td>{{ $po->po_number }}</td>
                                    <td>{{ $po->supplier ? $po->supplier->name : 'N/A' }}</td>
                                    <td><span class="badge bg-secondary">{{ $po->status }}</span></td>
                                    <td>Rs. {{ number_format($po->total_amount, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No purchase orders yet</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Recent Orders</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Order Number</th>
                                <th>Customer</th>
                                <th>Status</th>
                                <th>Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                                <tr>
                                    <td>{{ $order->order_number }}</td>
                                    <td>{{ $order->customer ? $order->customer->name : 'N/A' }}</td>
                                    <td><span class="badge bg-secondary">{{ $order->status }}</span></td>
                                    <td>Rs. {{ number_format($order->total_amount, 2) }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">No orders yet</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Stock Levels Chart (Bar Chart)
    const stockCtx = document.getElementById('stockChart').getContext('2d');
    new Chart(stockCtx, {
        type: 'bar',
        data: {
            labels: @json($stockLabels),
            datasets: [{
                label: 'Quantity',
                data: @json($stockQuantities),
                backgroundColor: [
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(255, 206, 86, 0.7)'
                ],
                borderColor: [
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(255, 206, 86, 1)'
                ],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // PO Status Chart (Doughnut Chart)
    const poStatusCtx = document.getElementById('poStatusChart').getContext('2d');
    const poData = @json(array_values($poStatusData));
    const poLabels = @json(array_keys($poStatusData));
    
    if(poData.length > 0 && poData.reduce((a, b) => a + b, 0) > 0) {
        new Chart(poStatusCtx, {
            type: 'doughnut',
            data: {
                labels: poLabels,
                datasets: [{
                    data: poData,
                    backgroundColor: [
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(75, 192, 192, 0.7)'
                    ],
                    borderColor: [
                        'rgba(255, 206, 86, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    } else {
        poStatusCtx.canvas.parentElement.innerHTML = '<p class="text-center text-muted">No data available</p>';
    }

    // Order Status Chart (Pie Chart)
    const orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
    const orderData = @json(array_values($orderStatusData));
    const orderLabels = @json(array_keys($orderStatusData));
    
    if(orderData.length > 0 && orderData.reduce((a, b) => a + b, 0) > 0) {
        new Chart(orderStatusCtx, {
            type: 'pie',
            data: {
                labels: orderLabels,
                datasets: [{
                    data: orderData,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.7)',
                        'rgba(54, 162, 235, 0.7)',
                        'rgba(255, 206, 86, 0.7)',
                        'rgba(75, 192, 192, 0.7)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    } else {
        orderStatusCtx.canvas.parentElement.innerHTML = '<p class="text-center text-muted">No data available</p>';
    }

    // Customer Type Chart (Doughnut Chart)
    const customerTypeCtx = document.getElementById('customerTypeChart').getContext('2d');
    const customerData = @json(array_values($customerTypeData));
    const customerLabels = @json(array_keys($customerTypeData));
    
    if(customerData.length > 0 && customerData.reduce((a, b) => a + b, 0) > 0) {
        new Chart(customerTypeCtx, {
            type: 'doughnut',
            data: {
                labels: customerLabels,
                datasets: [{
                    data: customerData,
                    backgroundColor: [
                        'rgba(153, 102, 255, 0.7)',
                        'rgba(255, 159, 64, 0.7)',
                        'rgba(255, 99, 132, 0.7)'
                    ],
                    borderColor: [
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    } else {
        customerTypeCtx.canvas.parentElement.innerHTML = '<p class="text-center text-muted">No data available</p>';
    }
</script>
@endpush