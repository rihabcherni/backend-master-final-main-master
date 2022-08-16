<?php

namespace App\Exports\GestionPanne;

use App\Models\Reparateur_poubelle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Reparateur_poubelleExport implements FromCollection ,WithHeadings{
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
        return collect(Reparateur_poubelle::getReparateurPoubelle());
    }
}
