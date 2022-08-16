<?php

namespace App\Exports\ProductionPoubelle;

use App\Models\Fournisseur;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FournisseurExport implements FromCollection , WithHeadings{
    public function headings():array{
        return[
            "ID",
            "Nom",
            "Prenom",
            "Carte identite national",
            "Photo",
            "Numero telephone",
            "E-mail",
            "Adresse",
            "Crée le",
            "Modifié le",
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect(Fournisseur::getFournisseur());
    }
}
