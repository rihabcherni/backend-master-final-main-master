<?php
namespace Database\Factories;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Client_dechetFactory extends Factory{
    public function definition(){
        $phone = '+216 '. $this->faker->randomNumber(8, true);
        $nom =  $this->faker->firstName;
        $prenom =  $this->faker->lastName;
        $email =  Str::lower($nom).'@gmail.com';
        $qr= Hash::make($email);
        return [
            'nom_entreprise'=> $this->faker->firstName,
            'nom'=> $nom,
            'prenom'=> $prenom,
            'matricule_fiscale'=> $this->faker->unique()->numerify('########'),
            'numero_telephone'=> $phone,
            'numero_fixe'=>  $this->faker->unique()->numerify('########'),
            'email'=> $email,
            'QRcode'=> $qr,
            'adresse'=> $this->faker->address,
            'mot_de_passe'=> Hash::make($this->faker->password),
            'remember_token' => Str::random(10),
        ];
    }
        /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
