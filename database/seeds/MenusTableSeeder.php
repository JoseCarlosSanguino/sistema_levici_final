<?php

use Illuminate\Database\Seeder;
use app\Models\Menu;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $m1 = factory(Menu::class)->create([
            'name' => 'Configuración',
            'slug' => 'configuracion',
            'parent' => 0,
            'order' => 0,
        ]);

        factory(Menu::class)->create([
            'name' => 'Proveedores',
            'slug' => 'providers',
            'parent' => $m1->id,
            'order' => 0,
        ]);
        factory(Menu::class)->create([
            'name' => 'Clientes',
            'slug' => 'cliente',
            'parent' => $m1->id,
            'order' => 1,
        ]);

        $m2 = factory(Menu::class)->create([
            'name' => 'Mercadería',
            'slug' => 'mercaderia',
            'parent' => 0,
            'order' => 1,
        ]);

        factory(Menu::class)->create([
            'name' => 'Artículos',
            'slug' => 'articulos',
            'parent' => $m2->id,
            'order' => 0,
        ]);
        
        $m3 = factory(Menu::class)->create([
            'name' => 'Facturación',
            'slug' => 'facturacion',
            'parent' => 0,
            'order' => 2,
        ]);

        factory(Menu::class)->create([
            'name' => 'Emitir factura',
            'slug' => 'factura',
            'parent' => $m3->id,
            'order' => 0,
        ]);
    }
}
