<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produit>
 */
class ProduitFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => $this->faker->word(), // Génère un mot aléatoire
            'description' => $this->faker->sentence(), // Génère une phrase aléatoire
            'prix' => $this->faker->randomFloat(2, 1, 1000), // Prix entre 1 et 1000 avec 2 décimales
            'quantite' => $this->faker->numberBetween(0, 100), // Quantité entre 0 et 100
        ];
    }
}