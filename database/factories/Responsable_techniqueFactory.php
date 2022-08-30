<?php

namespace Database\Factories;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;
class Responsable_techniqueFactory extends Factory{
    public function definition(){
        return [
            'nom'=> $this->faker->firstName,
            'prenom'=> $this->faker->lastName,
            'CIN'=> $this->faker->unique()->numerify('########'),
            'photo' =>'default.jpeg',
            'numero_telephone'=> $this->faker->unique()->e164PhoneNumber,
            'email'=> $this->faker->safeEmail,
            'adresse'=> $this->faker->address,
            'mot_de_passe'=> Hash::make($this->faker->password),
        ];
    }
}
