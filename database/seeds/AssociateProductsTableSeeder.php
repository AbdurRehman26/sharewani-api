<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class AssociateProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

    $date = Carbon::now()->toDateTimeString();

    $products = \App\Data\Models\Product::all()->pluck('id');
    
    $categories = \App\Data\Models\Category::all()->pluck('id')->toArray();
    shuffle($categories);    

    $events = \App\Data\Models\Event::all()->pluck('id')->toArray();
    shuffle($events);    
    
    foreach ($products as $key => $productId) {
    
        $productEventData[] = [
            'product_id' => $productId,
            'event_id' => $events[0],
            'created_at' => $date
        ];

        $productCategoryData[] = [
            'product_id' => $productId,
            'category_id' => $categories[0],
            'created_at' => $date
        ];
    
    }

            \App\Data\Models\ProductCategory::insertOnDuplicateKey($productCategoryData);
            \App\Data\Models\ProductEvent::insertOnDuplicateKey($productEventData);


}
}
