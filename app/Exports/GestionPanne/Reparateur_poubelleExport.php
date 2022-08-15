<?php

namespace App\Exports\GestionPanne;

use App\Models\Reparateur_poubelle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Reparateur_poubelleExport implements FromCollection ,WithHeadings{
    public function headings():array{
        return[
            "ID",
            "Crée le",
            "Modifié le",
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect(Reparateur_poubelle::getReparateurPoubelle());
    }
}
