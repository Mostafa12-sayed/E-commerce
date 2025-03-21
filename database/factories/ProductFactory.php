<?php

namespace Database\Factories;

use Illuminate\Support\Facades\Http;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    // return [
    //     'name' => $this->faker->name(),
    //     'description' => $this->faker->text(),
    //     'price' => $this->faker->randomFloat(2, 10, 1000),
    //     'quantity' => $this->faker->randomDigit(),
    //     'image' => $this->faker->imageUrl(),
    // ];
    public function definition()
    {
        $imageUrl = "https://picsum.photos/640/480"; // عنوان URL بديل
        $response = Http::get($imageUrl);

        if ($response->successful()) {
            $imageName = 'products/' . uniqid() . '.jpg';
            Storage::disk('public')->put($imageName, $response->body());
        } else {
            $imageName = 'default-product.jpg'; // صورة افتراضية في حالة الفشل
        }

        return [
            'name' => $this->faker->word(),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'image' => $imageName,
            'quantity' => $this->faker->randomDigit(),

        ];
    }
}
