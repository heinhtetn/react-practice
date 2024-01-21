<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::create([
            'name' => 'usereone',
            'email' => 'userone@gmail.com',
            'password' => Hash::make('password'),
            'image' => "user.jpeg",
            'phone' => '099898989',
            'address' => 'Yangon'
        ]);

        Admin::create([
            'name' => 'adminone',
            'email' => 'adminone@gmail.com',
            'password' => Hash::make('password')
        ]);

        $category = ['T-Shirt', 'Hat', 'Electronic', 'Mobile', 'Earphone'];
        foreach($category as $c)
        {
            Category::create([
                'slug' => Str::slug($c),
                'name' => $c,
                'mm_name' => 'မြန်မာ',
                'image' => 'category.webp'
            ]);
        }

        $brand = ['Samsung', 'Hwawei', 'Apple'];
        foreach($brand as $b)
        {
            Brand::create([
                'slug' => Str::slug($b),
                'name' => $b
            ]);
        }

        $color = ['Red', 'Green', 'Blue', 'Black'];
        foreach($color as $col)
        {
            Color::create([
                'slug' => Str::slug($col),
                'name' => $col
            ]);
        }

        Supplier::create([
            'name' => 'Mg Mg',
            'image' => 'supplier.png'
        ]);

    }
}
