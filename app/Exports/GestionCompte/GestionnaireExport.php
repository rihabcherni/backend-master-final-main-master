<?php

namespace App\Exports\GestionCompte;

use App\Models\Gestionnaire;
use Maatwebsite\Excel\Concerns\FromCollection;

class GestionnaireExport implements FromCollection
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
        return collect(Gestionnaire::getGestionnaire());
    }
}
