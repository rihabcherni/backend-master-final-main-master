<?php

namespace App\Exports\GestionPoubelleEtablissements;

use App\Models\Etablissement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EtablissementExport implements FromCollection ,WithHeadings{
    public function headings():array{
        return[
            "ID",
            "Region",
            "ID camion",
            "Nom etablissement",
            "Niveau etablissement",
            "Type etablissement",
            "Nombre personnes",
            "Url map",
            "Adresse",
            "Longitude",
            "Latitude",
            "Quantite dechets plastique actuelle",
            "Quantite dechets composte actuelle",
            "Quantite dechets papier actuelle",
            "Quantite dechets canette actuelle",
            "Quantite plastique mensuel",
            "Quantite papier mensuel",
            "Quantite composte mensuel",
            "Quantite canette mensuel",
            "Crée le",
            "Modifié le",
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect(Etablissement::getEtablissement());
    }
}
