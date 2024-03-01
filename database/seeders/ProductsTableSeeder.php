<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Variables a utilizar con los juegos para randomizar el contenido
        $platforms = ['PC', 'Ps5', 'Xbox', 'Nintendo Switch'];
        $launchers = ['Steam', 'Ubisoft Connect', 'EA App', 'Battle.net', 'Rockstar', 'GOG.com', 'Epic'];
        // Generar 5 productos para cada combinación de platform y launcher
        foreach ($platforms as $platform) {
            foreach ($launchers as $launcher) {
                for ($i = 1; $i <= 5; $i++) {
                    $product = Product::create([
                        'name' => "Juego $i para $platform",
                        'description' => "Descripción del juego $i para $platform en $launcher.",
                        'price' => rand(50, 200), // Precio aleatorio entre 50 y 200
                        'stock' => rand(10, 50), // Stock aleatorio entre 10 y 50
                        'developer' => "Desarrollador $i",
                        'publisher' => "Editor $i",
                        'show' => true,
                        'platform' => $platform,
                        'launcher' => $launcher,
                        'users_id' => 1,
                    ]);
                    // Obtener una imagen aleatoria de la base de datos
                    $image = Image::inRandomOrder()->first();

                    // Asociar la imagen al producto
                    if ($image) {
                        $product->images()->attach($image->id);
                    }
                }
            }
        }
    }
}
