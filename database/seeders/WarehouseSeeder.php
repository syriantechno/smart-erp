<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\Warehouse;
use App\Models\Material;
use App\Models\Inventory;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create parent categories
        $electronics = Category::create([
            'code' => 'ELEC001',
            'name' => 'Electronics',
            'description' => 'Electronic devices and components',
            'is_active' => true
        ]);

        $clothing = Category::create([
            'code' => 'CLOTH001',
            'name' => 'Clothing',
            'description' => 'Clothing and apparel',
            'is_active' => true
        ]);

        // Create child categories
        Category::create([
            'code' => 'ELEC-SMART',
            'name' => 'Smartphones',
            'description' => 'Mobile phones and smartphones',
            'parent_id' => $electronics->id,
            'is_active' => true
        ]);

        Category::create([
            'code' => 'ELEC-LAPTOP',
            'name' => 'Laptops',
            'description' => 'Laptop computers',
            'parent_id' => $electronics->id,
            'is_active' => true
        ]);

        Category::create([
            'code' => 'CLOTH-MEN',
            'name' => 'Men Clothing',
            'description' => 'Men\'s clothing items',
            'parent_id' => $clothing->id,
            'is_active' => true
        ]);

        // Create warehouses
        $mainWarehouse = Warehouse::create([
            'code' => 'WH001',
            'name' => 'Main Warehouse',
            'location' => 'Downtown Storage Facility',
            'description' => 'Primary storage location',
            'is_active' => true
        ]);

        $branchWarehouse = Warehouse::create([
            'code' => 'WH002',
            'name' => 'Branch Warehouse',
            'location' => 'North Branch Storage',
            'description' => 'Secondary storage location',
            'is_active' => true
        ]);

        // Create materials
        $smartphone = Material::create([
            'code' => 'MAT001',
            'name' => 'iPhone 15 Pro',
            'description' => 'Latest iPhone model with advanced features',
            'category_id' => $electronics->id,
            'unit' => 'piece',
            'price' => 999.99,
            'is_active' => true
        ]);

        $laptop = Material::create([
            'code' => 'MAT002',
            'name' => 'MacBook Pro 16"',
            'description' => 'Professional laptop for developers',
            'category_id' => $electronics->id,
            'unit' => 'piece',
            'price' => 2499.99,
            'is_active' => true
        ]);

        $tshirt = Material::create([
            'code' => 'MAT003',
            'name' => 'Cotton T-Shirt',
            'description' => 'Comfortable cotton t-shirt',
            'category_id' => $clothing->id,
            'unit' => 'piece',
            'price' => 29.99,
            'is_active' => true
        ]);

        // Create inventory
        Inventory::create([
            'material_id' => $smartphone->id,
            'warehouse_id' => $mainWarehouse->id,
            'quantity' => 50,
            'unit_price' => 999.99,
        ]);

        Inventory::create([
            'material_id' => $smartphone->id,
            'warehouse_id' => $branchWarehouse->id,
            'quantity' => 25,
            'unit_price' => 999.99,
        ]);

        Inventory::create([
            'material_id' => $laptop->id,
            'warehouse_id' => $mainWarehouse->id,
            'quantity' => 15,
            'unit_price' => 2499.99,
        ]);

        Inventory::create([
            'material_id' => $tshirt->id,
            'warehouse_id' => $mainWarehouse->id,
            'quantity' => 100,
            'unit_price' => 29.99,
        ]);

        $this->command->info('Warehouse data seeded successfully!');
    }
}
