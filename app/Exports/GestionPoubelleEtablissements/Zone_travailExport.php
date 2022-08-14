<?php

namespace App\Exports\GestionPoubelleEtablissements;

use App\Models\Zone_travail;
use Maatwebsite\Excel\Concerns\FromCollection;

class Zone_travailExport implements FromCollection{
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
