<?php

namespace App\Exports\GestionPoubelleEtablissements;

use App\Models\Bloc_etablissement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Bloc_etablissementExport implements FromCollection ,WithHeadings{
    public function headings():array{
        return[
            "ID",
            "Etablissement",
            "Nom bloc etablissement",
            "Crée le",
            "Modifié le",
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect(Bloc_etablissement::getBlocEtablissement());
    }
}
