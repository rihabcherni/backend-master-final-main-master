<?php

namespace App\Exports\GestionPanne;

use App\Models\Mecanicien;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MecanicienExport implements FromCollection ,WithHeadings{
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
        return collect(Mecanicien::getMecanicien());
    }
}
