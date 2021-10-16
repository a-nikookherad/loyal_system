<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $catData = [
            [
                "slug" => "unknown",
                "title" => "بدون دسته بندی",
                "subtitle" => "دسته بندی وجود ندارد",
                "description" => "این دسته بندی از نوع بدون دسته است یعنی اگر برای پستی دسته بندی انتخاب نشود این دسته بندی به صورت پیش فرض انتخاب میشود",
                "parent_id" => null,
            ]
        ];
        foreach ($catData as $catDatum) {
            Category::query()
                ->create($catDatum);
        }
    }
}
