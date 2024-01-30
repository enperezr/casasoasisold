<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(RolTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(ActionsTableSeeder::class);
        $this->call(KitchenTableSeeder::class);
        $this->call(StatePropertyTableSeeder::class);
        $this->call(GroupsTypesPropertyTableSeeder::class);
        $this->call(TypePropertyTableSeeder::class);
        $this->call(TypeConstructionTableSeeder::class);
        $this->call(ProvinceTableSeeder::class);
        $this->call(MunicipioTableSeeder::class);
        $this->call(TypesErrorsTableSeeder::class);
        $this->call(CommoditiesTableSeeder::class);
        $this->call(LocalitiesTableSeeder::class);
        //$this->call(ContactsTableSeeder::class);
        //$this->call(PropertyTableSeeder::class);
        //$this->call(PropertiesActionTableSeeder::class);
        //$this->call(PropertiesCommoditiesTableSeeder::class);
        //$this->call(ImagesTableSeeder::class);
        $this->call(ServicesTableSeeder::class);
        Model::reguard();
    }
}
