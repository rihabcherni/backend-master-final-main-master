<?php

namespace App\Exports\GestionCompte;

use App\Models\Responsable_etablissement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Responsable_etablissementExport implements FromCollection ,WithHeadings{
    public function headings():array{
        return[
            "ID",
            "etablissement_id",
            "etablissement",
            "nom",
            "prenom",
            "photo",
            "numero_fixe",
            "adresse",
            "numero_telephone",
            "email",
            "Cree le",
            "Modifie le",
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect(Responsable_etablissement::getResponsableEtablissement());
    }
}
