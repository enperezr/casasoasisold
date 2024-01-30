<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertiesActionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('properties_actions')->insert([
            'id'=>1,
            'property_id'=>1,
            'action_id'=>1,
            'contact_id'=>1,
            'protected_by'=>2,
            'price'=>12000,
            'permuta'=>null,
            'frequency'=>null,
            'description'=>'Vendo apartamento ubicado en E y 29, Vedado. Tiene 4 cuartos, 2 baños, sala, cocina, comedor, patio, balcon, hall. Construccion capitalista sin modificaciones, pisos originales. Corriente 110v y 220v. No se va la luz',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        DB::table('properties_actions')->insert([
            'id'=>2,
            'property_id'=>2,
            'action_id'=>2,
            'contact_id'=>1,
            'price'=>null,
            'permuta'=>'1x1',
            'frequency'=>null,
            'description'=>'Vendo apartamento ubicado en E y 29, Vedado. Tiene 4 cuartos, 2 baños, sala, cocina, comedor, patio, balcon, hall. Construccion capitalista sin modificaciones, pisos originales. Corriente 110v y 220v. No se va la luz',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        DB::table('properties_actions')->insert([
            'id'=>3,
            'property_id'=>3,
            'action_id'=>2,
            'contact_id'=>1,
            'price'=>null,
            'permuta'=>'1x1',
            'frequency'=>null,
            'description'=>'Vendo apartamento ubicado en E y 29, Vedado. Tiene 4 cuartos, 2 baños, sala, cocina, comedor, patio, balcon, hall. Construccion capitalista sin modificaciones, pisos originales. Corriente 110v y 220v. No se va la luz',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        DB::table('properties_actions')->insert([
            'id'=>4,
            'property_id'=>4,
            'action_id'=>1,
            'contact_id'=>1,
            'protected_by'=>2,
            'price'=>95000,
            'permuta'=>null,
            'frequency'=>null,
            'description'=>'Vendo apartamento ubicado en E y 29, Vedado. Tiene 4 cuartos, 2 baños, sala, cocina, comedor, patio, balcon, hall. Construccion capitalista sin modificaciones, pisos originales. Corriente 110v y 220v. No se va la luz',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        DB::table('properties_actions')->insert([
            'id'=>5,
            'property_id'=>4,
            'action_id'=>4,
            'contact_id'=>1,
            'price'=>200,
            'permuta'=>null,
            'frequency'=>24*30,
            'description'=>'Vendo apartamento ubicado en E y 29, Vedado. Tiene 4 cuartos, 2 baños, sala, cocina, comedor, patio, balcon, hall. Construccion capitalista sin modificaciones, pisos originales. Corriente 110v y 220v. No se va la luz',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        DB::table('properties_actions')->insert([
            'id'=>6,
            'property_id'=>5,
            'action_id'=>1,
            'contact_id'=>1,
            'protected_by'=>2,
            'price'=>18000,
            'permuta'=>null,
            'frequency'=>null,
            'description'=>'Vendo apartamento ubicado en E y 29, Vedado. Tiene 4 cuartos, 2 baños, sala, cocina, comedor, patio, balcon, hall. Construccion capitalista sin modificaciones, pisos originales. Corriente 110v y 220v. No se va la luz',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        DB::table('properties_actions')->insert([
            'id'=>7,
            'property_id'=>6,
            'action_id'=>1,
            'contact_id'=>1,
            'price'=>85000,
            'permuta'=>null,
            'frequency'=>null,
            'description'=>'Vendo apartamento ubicado en E y 29, Vedado. Tiene 4 cuartos, 2 baños, sala, cocina, comedor, patio, balcon, hall. Construccion capitalista sin modificaciones, pisos originales. Corriente 110v y 220v. No se va la luz',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        DB::table('properties_actions')->insert([
            'id'=>8,
            'property_id'=>7,
            'action_id'=>2,
            'contact_id'=>1,
            'price'=>null,
            'permuta'=>'1x2',
            'frequency'=>null,
            'description'=>'Vendo apartamento ubicado en E y 29, Vedado. Tiene 4 cuartos, 2 baños, sala, cocina, comedor, patio, balcon, hall. Construccion capitalista sin modificaciones, pisos originales. Corriente 110v y 220v. No se va la luz',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        DB::table('properties_actions')->insert([
            'id'=>9,
            'property_id'=>8,
            'action_id'=>3,
            'contact_id'=>1,
            'price'=>25,
            'permuta'=>null,
            'frequency'=>24,
            'description'=>'Vendo apartamento ubicado en E y 29, Vedado. Tiene 4 cuartos, 2 baños, sala, cocina, comedor, patio, balcon, hall. Construccion capitalista sin modificaciones, pisos originales. Corriente 110v y 220v. No se va la luz',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        DB::table('properties_actions')->insert([
            'id'=>10,
            'property_id'=>9,
            'action_id'=>1,
            'contact_id'=>1,
            'price'=>180000,
            'permuta'=>null,
            'frequency'=>null,
            'description'=>'Vendo apartamento ubicado en E y 29, Vedado. Tiene 4 cuartos, 2 baños, sala, cocina, comedor, patio, balcon, hall. Construccion capitalista sin modificaciones, pisos originales. Corriente 110v y 220v. No se va la luz',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        DB::table('properties_actions')->insert([
            'id'=>11,
            'property_id'=>10,
            'action_id'=>1,
            'contact_id'=>1,
            'price'=>30000,
            'permuta'=>null,
            'frequency'=>null,
            'description'=>'Vendo apartamento ubicado en E y 29, Vedado. Tiene 4 cuartos, 2 baños, sala, cocina, comedor, patio, balcon, hall. Construccion capitalista sin modificaciones, pisos originales. Corriente 110v y 220v. No se va la luz',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        DB::table('properties_actions')->insert([
            'id'=>12,
            'property_id'=>11,
            'action_id'=>2,
            'contact_id'=>1,
            'price'=>null,
            'permuta'=>'1x3',
            'frequency'=>null,
            'description'=>'Vendo apartamento ubicado en E y 29, Vedado. Tiene 4 cuartos, 2 baños, sala, cocina, comedor, patio, balcon, hall. Construccion capitalista sin modificaciones, pisos originales. Corriente 110v y 220v. No se va la luz',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
        DB::table('properties_actions')->insert([
            'id'=>13,
            'property_id'=>12,
            'action_id'=>1,
            'contact_id'=>1,
            'price'=>20000,
            'permuta'=>null,
            'frequency'=>null,
            'description'=>'Vendo apartamento ubicado en E y 29, Vedado. Tiene 4 cuartos, 2 baños, sala, cocina, comedor, patio, balcon, hall. Construccion capitalista sin modificaciones, pisos originales. Corriente 110v y 220v. No se va la luz',
            'created_at'=>\Carbon\Carbon::now(),
            'updated_at'=>\Carbon\Carbon::now()
        ]);
    }
}
