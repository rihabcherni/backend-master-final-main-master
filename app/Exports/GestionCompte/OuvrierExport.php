<?php

namespace App\Exports\GestionCompte;

use App\Models\Ouvrier;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OuvrierExport implements FromCollection ,WithHeadings{
    public function headings():array{
        return[
            "ID",
            "camion_id",
            "matricule",
            "poste",
            "Nom",
            "Prenom",
            "Adresse",
            "CIN",
            "photo",
            "Numero telephone",
            "E-mail",
            "Crée le",
            "Modifié le",
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect(Ouvrier::getOuvrier());
    }
}
