<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Supplier;
use App\Models\Customer;
use App\Models\Stock;
use App\Models\DeliveryRoute;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gas.com',
            'password' => Hash::make('password'),
        ]);

        // Create Suppliers
        Supplier::create([
            'name' => 'Laugfs Gas',
            'contact' => '0112345678',
            'address' => 'Colombo 03, Sri Lanka',
            'rate_2_8kg' => 850.00,
            'rate_5kg' => 1200.00,
            'rate_12_5kg' => 2500.00,
        ]);

        Supplier::create([
            'name' => 'Litro Gas',
            'contact' => '0112345679',
            'address' => 'Colombo 05, Sri Lanka',
            'rate_2_8kg' => 860.00,
            'rate_5kg' => 1220.00,
            'rate_12_5kg' => 2550.00,
        ]);

        Supplier::create([
            'name' => 'Shell Gas',
            'contact' => '0112345680',
            'address' => 'Colombo 07, Sri Lanka',
            'rate_2_8kg' => 870.00,
            'rate_5kg' => 1250.00,
            'rate_12_5kg' => 2600.00,
        ]);

        // Create Customers
        Customer::create([
            'name' => 'ABC Restaurant',
            'type' => 'commercial',
            'contact' => '0771234567',
            'address' => 'Galle Road, Colombo 03',
            'credit_limit' => 50000.00,
            'balance' => 0,
            'price_2_8kg' => 1000.00,
            'price_5kg' => 1400.00,
            'price_12_5kg' => 2800.00,
        ]);

        Customer::create([
            'name' => 'XYZ Hotel',
            'type' => 'commercial',
            'contact' => '0771234568',
            'address' => 'Marine Drive, Colombo 04',
            'credit_limit' => 100000.00,
            'balance' => 0,
            'price_2_8kg' => 1000.00,
            'price_5kg' => 1400.00,
            'price_12_5kg' => 2800.00,
        ]);

        Customer::create([
            'name' => 'Gas Dealer - Moratuwa',
            'type' => 'dealer',
            'contact' => '0771234569',
            'address' => 'Moratuwa, Sri Lanka',
            'credit_limit' => 200000.00,
            'balance' => 0,
            'price_2_8kg' => 950.00,
            'price_5kg' => 1350.00,
            'price_12_5kg' => 2700.00,
        ]);

        Customer::create([
            'name' => 'John Silva',
            'type' => 'individual',
            'contact' => '0771234570',
            'address' => 'Nugegoda, Sri Lanka',
            'credit_limit' => 5000.00,
            'balance' => 0,
            'price_2_8kg' => 1100.00,
            'price_5kg' => 1500.00,
            'price_12_5kg' => 3000.00,
        ]);

        Customer::create([
            'name' => 'Mary Fernando',
            'type' => 'individual',
            'contact' => '0771234571',
            'address' => 'Dehiwala, Sri Lanka',
            'credit_limit' => 5000.00,
            'balance' => 0,
            'price_2_8kg' => 1100.00,
            'price_5kg' => 1500.00,
            'price_12_5kg' => 3000.00,
        ]);

        // Initialize Stock
        Stock::create([
            'gas_type' => '2.8kg',
            'quantity' => 100,
        ]);

        Stock::create([
            'gas_type' => '5kg',
            'quantity' => 150,
        ]);

        Stock::create([
            'gas_type' => '12.5kg',
            'quantity' => 200,
        ]);

        // Create Delivery Routes
        DeliveryRoute::create([
            'route_name' => 'Colombo Route 1',
            'driver_name' => 'Kamal Perera',
            'assistant_name' => 'Nimal Silva',
            'route_date' => now(),
            'planned_start_time' => '08:00',
            'planned_end_time' => '17:00',
        ]);

        DeliveryRoute::create([
            'route_name' => 'Dehiwala Route',
            'driver_name' => 'Sunil Fernando',
            'assistant_name' => 'Anil Kumar',
            'route_date' => now(),
            'planned_start_time' => '09:00',
            'planned_end_time' => '18:00',
        ]);

        DeliveryRoute::create([
            'route_name' => 'Moratuwa Route',
            'driver_name' => 'Ravi Jayasinghe',
            'assistant_name' => 'Chaminda Dias',
            'route_date' => now()->addDay(),
            'planned_start_time' => '08:30',
            'planned_end_time' => '17:30',
        ]);

        $this->command->info('Database seeded successfully!');
    }
}