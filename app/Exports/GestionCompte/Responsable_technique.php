<?php

namespace App\Exports\GestionCompte;

use App\Models\Responsable_technique;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Responsable_techniqueExport implements FromCollection ,WithHeadings{
    public function headings():array{
        return[
            "ID",
            "Nom",
            "Prenom",
            "Carte identité national",
            "Photo",
            "Numero telephone",
            "E-mail",
            "Adresse",
            "Crée le",
            "Modifié le",
        ];
    }
    public function collection(){
        return collect(Responsable_technique::getReparateurPoubelle());
    }
}
