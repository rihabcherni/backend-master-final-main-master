<?php

namespace App\Exports\GestionPoubelleEtablissements;

use App\Models\Bloc_poubelle;
use Maatwebsite\Excel\Concerns\FromCollection;

class Bloc_poubelleExport implements FromCollection{
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
