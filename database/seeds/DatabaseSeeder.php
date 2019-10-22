<?php

use App\Laravue\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        /* Required Seeders && Default Options */
        $this->call(CategoryTableSeeder::class);
        $this->call(EventTableSeeder::class);
        $this->call(CityTableSeeder::class);
        $this->call(ColorTableSeeder::class);
        $this->call(BrandTableSeeder::class);
        $this->call(FabricAgeTableSeeder::class);
        $this->call(SizeTableSeeder::class);


        /* Required Seeders */

        $this->call(UsersTableSeeder::class);
        
        /* Extra Populated Data */
        $this->call(UserAddressTableSeeder::class);
        $this->call(ProductTableSeeder::class);
        $this->call(AssociateProductsTableSeeder::class);
        $this->call(OrderTableSeeder::class);
        $this->call(ContactUsTableSeeder::class);

    }
}
