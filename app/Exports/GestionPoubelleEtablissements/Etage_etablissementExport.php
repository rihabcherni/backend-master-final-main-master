<?php

namespace App\Exports\GestionPoubelleEtablissements;

use App\Models\Etage_etablissement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Etage_etablissementExport implements FromCollection ,WithHeadings{
    public function headings():array{
        return[
            "ID",
            "Etage etablissement",
            "Bloc etablissement",
            "Etablissement",
            "Crée le",
            "Modifié le",
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect(Etage_etablissement::getEtageEtablissement());
    }
}
