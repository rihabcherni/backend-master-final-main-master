<?php

namespace App\Exports\GestionCompte;

use App\Models\Responsable_etablissement;
use Maatwebsite\Excel\Concerns\FromCollection;

class Responsable_etablissementExport implements FromCollection
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
