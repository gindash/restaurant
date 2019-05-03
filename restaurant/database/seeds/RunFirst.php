<?php

use Illuminate\Database\Seeder;

class RunFirst extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('users')->delete();
        DB::table('department')->delete();
        DB::connection('mongodb')->collection('products')->delete();
        DB::connection('mongodb')->collection('sales_order')->delete();

        try {
            //code...
            DB::table('departments')->insert([
                'name' => 'admin',
                'routes' => 'department.store,department.update,department.index,logout,active-sales-orders.index,my-sales-orders.index,sales-order.store,sales-order.update,sales-order.setstatus,sales-order.index,product.store,product.update,product.index,products-ready.index,user.store',
            ]);

            DB::table('users')->insert([
                'department_id' => DB::table('departments')->where('name', 'admin')->first()->id,
                'name' => 'admin',
                'email' => 'admin@mail.xx',
                'password' => \Illuminate\Support\Facades\Hash::make('admin123'),
            ]);

            DB::table('departments')->insert([
                'name' => 'pelayan',
                'routes' => 'logout,active-sales-orders.index,my-sales-orders.index,sales-order.store,sales-order.update,products-ready.index',
            ]);

            DB::table('users')->insert([
                'department_id' => DB::table('departments')->where('name', 'pelayan')->first()->id,
                'name' => 'danang',
                'email' => 'danang@mail.xx',
                'password' => \Illuminate\Support\Facades\Hash::make('danang123'),
            ]);

            DB::table('departments')->insert([
                'name' => 'kasir',
                'routes' => 'logout,active-sales-orders.index,sales-order.setstatus',
            ]);

            DB::table('users')->insert([
                'department_id' => DB::table('departments')->where('name', 'kasir')->first()->id,
                'name' => 'darto',
                'email' => 'darto@mail.xx',
                'password' => \Illuminate\Support\Facades\Hash::make('darto123'),
            ]);

            //products
            DB::connection('mongodb')->collection('products')->insert([
                "name" => "Pecel Lele",
                "category" => "foods",
                "price" => "13000",
                "status" => "ready",
            ]);
            DB::connection('mongodb')->collection('products')->insert([
                "name" => "Ayam Goreng",
                "category" => "foods",
                "price" => "15000",
                "status" => "ready",
            ]);
            DB::connection('mongodb')->collection('products')->insert([
                "name" => "Es Teh Manis",
                "category" => "drinks",
                "price" => "5000",
                "status" => "ready",
            ]);

        } catch (\Throwable $th) {
            //throw $th;
            DB::table('users')->delete();
            DB::table('department')->delete();
            DB::connection('mongodb')->collection('products')->delete();
        }
    }
}
