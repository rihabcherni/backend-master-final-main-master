<?php

namespace App\Exports\GestionPanne;

use App\Models\Reparation_poubelle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Reparation_poubelleExport implements FromCollection ,WithHeadings{
    public function headings():array{
        return[
            "ID",

            "Reparateur poubelle",
            "Nom et pernom",
            "Carte identité national",

            "ID Poubelle",
            "Nom poubelle",
            "Type",
            "Etablissement",
            "Bloc etablissement",
            "Etage",
            "ID Bloc poubelle",

            "Image panne",
            "Description panne",
            "Cout",
            "Date debut reparation",
            "Date fin reparation",
            "Crée le",
            "Modifié le",
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect(Reparation_poubelle::getReparationPoubelle());
    }
}
