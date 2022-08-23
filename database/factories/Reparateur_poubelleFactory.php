<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class Reparateur_poubelleFactory extends Factory{
    public function definition(){
        $email =  $this->faker->safeEmail;
        $qr= Hash::make($email);
        return [
            'nom'=> $this->faker->firstName,
            'prenom'=> $this->faker->lastName,
            'CIN'=> $this->faker->unique()->numerify('########'),
            'photo' =>'default.jpeg',
            'numero_telephone'=> $this->faker->unique()->e164PhoneNumber,
            'email'=> $email,
            'adresse'=> $this->faker->address,
            'QRcode' => $qr,
            'mot_de_passe'=> Hash::make($this->faker->password),
        ];
    }
}
