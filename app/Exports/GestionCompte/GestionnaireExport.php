<?php

namespace App\Exports\GestionCompte;

use App\Models\Gestionnaire;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class GestionnaireExport implements FromCollection ,WithHeadings{
    public function headings():array{
        return[
            "ID",
            "Nom",
            "Prenom",
            "CIN",
            "Photo",
            "Adresse",
            "Numéro télephone",
            "E-mail",
            "Cree le",
            "Modifie le",
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect(Gestionnaire::getGestionnaire());
    }
}
