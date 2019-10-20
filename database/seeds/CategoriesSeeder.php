<?php

use Illuminate\Database\Seeder;
use App\category;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = new category();
        $category->name = 'Sticker';
        $category->permalink = 'sticker';

        $category->save();
    }
}
