<?php
namespace Database\Factories;

use App\Models\Responsable_etablissement;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class Responsable_etablissementFactory extends Factory{
    protected $model = Responsable_etablissement::class;
    public function definition(){
        $email =  $this->faker->safeEmail;
        $fixe =$this->faker->randomNumber(8, true);
        $qr= Hash::make($email);
        return [
            'etablissement_id'=>\App\Models\Etablissement::all()->random()->id,
            'nom'=> $this->faker->firstName,
            'prenom'=> $this->faker->lastName,
            'photo' =>'default.jpeg',
            'numero_telephone'=> $this->faker->unique()->e164PhoneNumber,
            'numero_fixe'=> $fixe,
            'email'=> $email,
            'adresse'=> $this->faker->address,
            'QRcode' => $qr,
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
