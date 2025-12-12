\*\*Table of Contents



Features



Tech Stack



System Requirements



Installation Guide



Database Setup



Default Login



Module Overview



Database Schema



Bonus Features



Screenshots



License



\## 🎥 Demo Video

👉 \[Click to watch the demo] [https://youtu.be/LFik1jvQR\_Y](https://youtu.be/LFik1jvQR_Y)



\*\*Features

\*Supplier Management



Add, edit, delete (soft delete) suppliers



Maintain contract rates for multiple gas cylinder sizes



Supplier ledger + payment records



Purchase Order Management



Create purchase orders with auto-calculated prices



Auto-generated PO numbers (PO-YYYYMMDD-0001)



Approval workflow



Track payments and outstanding amounts



Goods Received Note (GRN)



Select approved POs and auto-load items



Record received, damaged, and short-supplied quantities



Stock updates automatically when approved



PO auto-closes when fully received



\*Supplier Payments



Record supplier payments (cash, cheque, bank transfer)



Payment history and balance tracking



\*Customer Management



Three customer types: Dealer, Commercial, Individual



Custom price levels



Credit limit monitoring



Soft delete + restore



\*Order Management



Create customer orders with auto-loaded prices



Status flow: Pending → Loaded → Delivered → Completed



Mark urgent orders



Assign orders to delivery routes



\*Delivery Routes



Create routes with driver/assistant



View assigned orders



Compare planned vs actual delivery times



\*Stock Management



Tracks live inventory by gas type



Stock adjusts when GRN is approved



Low-stock warnings on dashboard



\*Dashboard



High-level summary of operations



Charts (using Chart.js):



Stock bar chart



PO status pie chart



Order status pie chart



Customer type doughnut chart



Recent orders and POs



Color-coded stock alerts



\*\*Tech Stack



PHP 8.1+



Laravel 10



Blade + Bootstrap 5



MySQL / MariaDB



Chart.js



Laravel Breeze (Authentication)



\*\*System Requirements



PHP >= 8.1



Composer



MySQL 8+



Node.js 16+



Git



\*\*Installation Guide

1\. Clone the Project

git clone https://github.com/Thushantha-nipuna/gas-distribution-system.git

cd gas-distribution



2\. Install PHP Dependencies

composer install



3\. Install Frontend Dependencies

npm install

npm run build



4\. Setup Environment

cp .env.example .env

php artisan key:generate





Update .env:



DB\_CONNECTION=mysql

DB\_HOST=127.0.0.1

DB\_PORT=3306

DB\_DATABASE=gas\_distribution

DB\_USERNAME=root

DB\_PASSWORD=



SESSION\_DRIVER=file

CACHE\_DRIVER=file



5\. Create the Database

CREATE DATABASE gas\_distribution;



6\. Run Migrations + Seeders

php artisan migrate

php artisan db:seed





The seeder creates:



1 admin user



Sample suppliers, customers, routes, and initial stock



7\. Start the Server

php artisan serve





Open http://localhost:8000



\*\*Default Login



Email: admin@gas.com



Password: password







\*\*Module Overview

Suppliers



/suppliers



Soft delete + restore



Ledger + payment history



Purchase Orders



/purchase-orders



Auto PO number



Total calculation



Approval system



GRN



/grns



Pull items from PO



Short-supply calculation



Auto-update stock



Customers



/customers



Different customer types



Soft delete + restore



Orders



/orders



Status updates



Route assignment



Routes



/delivery-routes



Driver + assistant details



Orders per route



\*\*Database Schema (Main Tables)



suppliers



purchase\_orders



purchase\_order\_items



grns



grn\_items



supplier\_payments



customers



orders



order\_items



delivery\_routes



stock



users



Key Relationships



Supplier → Purchase Orders → PO Items



Purchase Orders → GRNs → GRN Items



Supplier → Payments



Customer → Orders → Order Items



Delivery Route → Orders



Stock table independent



\*\*Bonus Features



Dashboard charts (Chart.js)



Soft delete for suppliers/customers



Restore deleted records



Not Included (but planned)



PDF exports



Activity logs



Roles/permissions



\*\*Testing Scenarios

Purchase Flow



Create supplier



Create PO



Approve PO



Create GRN



Approve GRN → Stock updates



Record supplier payment



Sales Flow



Create customer



Set prices



Create order



Assign route



Update status until completed



Soft Delete Flow



Delete supplier



View deleted list



Restore supplier



\*\*Common Fixes



Migration issues



php artisan migrate:fresh --seed





Class issues



composer dump-autoload





Cache issues



php artisan config:clear

php artisan cache:clear

php artisan route:clear

php artisan view:clear





CSS/JS not updating



npm run build



\*\*Possible Future Improvements



PDF downloads for PO/GRN



Email alerts (e.g., low stock)



More reporting



Role-based access



Mobile app for delivery team



Barcode support



Live delivery tracking



\*\*Notes for Developers



Follows Laravel best practices



Proper naming conventions



Eloquent relationships



CSRF protection



Validations on all forms



Uses eager loading for performance



\*\*Contact



Email: nipunathushantha@gmail.com



GitHub: https://github.com/Thushantha-nipuna

