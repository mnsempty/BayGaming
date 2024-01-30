<?php

namespace Database\Seeders;

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
        Product::create([
            'name' => 'Juego 1',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc aliquet nulla quis libero tempus, sed posuere lectus ornare. In a odio sapien. Proin pretium, arcu quis ultricies pretium, augue purus pulvinar risus, ut maximus quam risus ornare nunc. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nulla tristique sodales felis et tristique. Integer aliquet, justo ac volutpat pretium, nibh risus pharetra diam, pharetra pellentesque ligula nisl sit amet arcu. Sed ultricies odio in ligula viverra, sit amet vehicula nunc malesuada. Praesent ut dolor quis mauris blandit gravida. Duis et neque sit amet tortor molestie fermentum. Vestibulum odio lorem, tempus vitae nunc id, suscipit pellentesque lacus. Aenean eget faucibus libero. Aliquam cursus, lorem ut venenatis rhoncus, neque orci vehicula justo, id bibendum velit ante sed nisl. Mauris sed nulla vel massa ullamcorper pulvinar.1',
            'price' => 100.00,
            'reviews_id' => null,
        ]);
    
        Product::create([
            'name' => 'Juego 2',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc aliquet nulla quis libero tempus, sed posuere lectus ornare. In a odio sapien. Proin pretium, arcu quis ultricies pretium, augue purus pulvinar risus, ut maximus quam risus ornare nunc. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nulla tristique sodales felis et tristique. Integer aliquet, justo ac volutpat pretium, nibh risus pharetra diam, pharetra pellentesque ligula nisl sit amet arcu. Sed ultricies odio in ligula viverra, sit amet vehicula nunc malesuada. Praesent ut dolor quis mauris blandit gravida. Duis et neque sit amet tortor molestie fermentum. Vestibulum odio lorem, tempus vitae nunc id, suscipit pellentesque lacus. Aenean eget faucibus libero. Aliquam cursus, lorem ut venenatis rhoncus, neque orci vehicula justo, id bibendum velit ante sed nisl. Mauris sed nulla vel massa ullamcorper pulvinar.2',
            'price' => 200.00,
            'reviews_id' => null,
        ]);
        /*
                    $table->id();
            $table->string('name');// string limite laravel 250
            $table->text('description');// se supone que sin limite
            $table->decimal('price', 10, 2);
            //stock
            $table->foreignId('reviews_id')->references("id")->on("reviews");
        */
    }
}
