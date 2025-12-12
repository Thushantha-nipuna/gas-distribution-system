<?php

namespace App\Http\Controllers;

use App\Models\DeliveryRoute;
use Illuminate\Http\Request;

class DeliveryRouteController extends Controller
{
    public function index()
    {
        $routes = DeliveryRoute::with('orders')->latest()->get();
        return view('delivery-routes.index', compact('routes'));
    }

    public function create()
    {
        return view('delivery-routes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'route_name' => 'required|string|max:255',
            'driver_name' => 'required|string|max:255',
            'assistant_name' => 'nullable|string|max:255',
            'route_date' => 'required|date',
            'planned_start_time' => 'nullable|date_format:H:i',
            'planned_end_time' => 'nullable|date_format:H:i',
        ]);

        DeliveryRoute::create($request->all());

        return redirect()->route('delivery-routes.index')->with('success', 'Delivery Route created successfully.');
    }

    public function show(DeliveryRoute $deliveryRoute)
{
    $deliveryRoute->load('orders.customer');
    return view('delivery-routes.show', compact('deliveryRoute'));
}

    public function edit(DeliveryRoute $deliveryRoute)
    {
        return view('delivery-routes.edit', compact('deliveryRoute'));
    }

    public function update(Request $request, DeliveryRoute $deliveryRoute)
    {
        $request->validate([
            'route_name' => 'required|string|max:255',
            'driver_name' => 'required|string|max:255',
            'assistant_name' => 'nullable|string|max:255',
            'route_date' => 'required|date',
            'planned_start_time' => 'nullable|date_format:H:i',
            'planned_end_time' => 'nullable|date_format:H:i',
            'actual_start_time' => 'nullable|date_format:H:i',
            'actual_end_time' => 'nullable|date_format:H:i',
        ]);

        $deliveryRoute->update($request->all());

        return redirect()->route('delivery-routes.index')->with('success', 'Delivery Route updated successfully.');
    }

    public function destroy(DeliveryRoute $deliveryRoute)
    {
        $deliveryRoute->delete();
        return redirect()->route('delivery-routes.index')->with('success', 'Delivery Route deleted successfully.');
    }
}