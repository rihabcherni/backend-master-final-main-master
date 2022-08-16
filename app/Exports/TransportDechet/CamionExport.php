<?php

namespace App\Exports\TransportDechet;

use App\Models\Camion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CamionExport implements FromCollection, WithHeadings{
    public function headings():array{
        return[
            "ID",
            "ID zone travail",
            "ID zone depot",
            "Matricule",
            "Heure sortie",
            "Heure entree",
            "Longitude",
            "Latitude",
            "Volume maximale camion",
            "Volume actuelle plastique",
            "Volume actuelle papier",
            "Volume actuelle composte",
            "Volume actuelle canette",
            "Volume carburant consomme",
            "Kilometrage",
            "Crée le",
            "Modifié le",
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect(Camion::getCamion());
    }
}
