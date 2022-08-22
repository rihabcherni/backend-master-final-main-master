<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class GestionnaireFactory extends Factory{
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
            'QRcode'=> $qr,
            'adresse'=> $this->faker->address,
            'mot_de_passe'=> Hash::make($this->faker->password),
            'remember_token' => Str::random(10),
        ];
    }
    public function unverified(){
        return $this->state(function (array $attributes) {
            return [ 'email_verified_at' => null];
        });
    }
}
