<?php

namespace App\Exports\GestionPanne;

use App\Models\Reparateur_poubelle;
use Maatwebsite\Excel\Concerns\FromCollection;

class Reparateur_poubelleExport implements FromCollection
{
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
        return collect(Gestionnaire::getPoubelle());
    }
}