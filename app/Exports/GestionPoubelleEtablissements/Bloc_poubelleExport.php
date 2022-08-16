<?php

namespace App\Exports\GestionPoubelleEtablissements;

use App\Models\Bloc_poubelle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Bloc_poubelleExport implements FromCollection ,WithHeadings{
    public function headings():array{
        return[
            "ID",
            "Etage",
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
        return collect(Bloc_poubelle::getBlocPoubelle());
    }
}
