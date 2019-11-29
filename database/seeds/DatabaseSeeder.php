<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        $categories = factory(App\Models\Category::class, 5)->create();
//        $items = factory(App\Models\Item::class, 5)->create();
//        foreach ($categories as $category) {
//                $category->items()->saveMany($items);
//        }

        factory(App\Models\User::class)->create([
            'email' => 'truongdinhson3003@gmail.com',
        ]);

        factory(App\Models\Admin::class)->create([
            'username' => 'admin',
            'email' => 'truongdinhson30031997@gmail.com',
        ]);
    }
}
