<?php

namespace App\Http\Controllers;

use App\Models\PurchaseOrder;
use App\Models\Order;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSuppliers = Supplier::count();
        $totalCustomers = Customer::count();
        $totalPurchaseOrders = PurchaseOrder::count();
        $totalOrders = Order::count();
        
        $pendingPOs = PurchaseOrder::where('status', 'pending')->count();
        $pendingOrders = Order::where('status', 'pending')->count();
        
        $stock = Stock::all();
        
        $recentPOs = PurchaseOrder::with('supplier')->latest()->take(5)->get();
        $recentOrders = Order::with('customer')->latest()->take(5)->get();

        // Chart Data: PO Status Distribution
        $poStatusData = PurchaseOrder::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Chart Data: Order Status Distribution
        $orderStatusData = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // Chart Data: Stock Levels
        $stockLabels = $stock->pluck('gas_type')->toArray();
        $stockQuantities = $stock->pluck('quantity')->toArray();

        // Chart Data: Customer Type Distribution
        $customerTypeData = Customer::select('type', DB::raw('count(*) as count'))
            ->groupBy('type')
            ->pluck('count', 'type')
            ->toArray();

        return view('dashboard', compact(
            'totalSuppliers',
            'totalCustomers',
            'totalPurchaseOrders',
            'totalOrders',
            'pendingPOs',
            'pendingOrders',
            'stock',
            'recentPOs',
            'recentOrders',
            'poStatusData',
            'orderStatusData',
            'stockLabels',
            'stockQuantities',
            'customerTypeData'
        ));
    }
}