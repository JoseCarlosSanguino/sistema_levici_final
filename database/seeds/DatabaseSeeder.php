<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // La creación de datos de roles debe ejecutarse primero
        $this->call(RoleTableSeeder::class);
        // Los usuarios necesitarán los roles previamente generados
        $this->call(UserTableSeeder::class);
        // Condiciones de iva
        $this->call(IvaconditionTableSeeder::class);
        // Tipos de iva
        $this->call(IvatypeTableSeeder::class);
        // Tipos de operaciones
        $this->call(OperationtypeTableSeeder::class);
        //Tipos de personas
        $this->call(PersontypeTableSeeder::class);
        //tipos de productos
        $this->call(ProducttypeTableSeeder::class);
        //Provincias
        $this->call(ProvinceTableSeeder::class);
        //estados
        $this->call(StatusTableSeeder::class);
        //unidades de medida
        $this->call(UnittypeTableSeeder::class);
        //menu
        $this->call(MenusTableSeeder::class);

    }
}
