<?php

namespace App\Exports\GestionPoubelleEtablissements;

use App\Models\Etablissement;
use Maatwebsite\Excel\Concerns\FromCollection;

class EtablissementExport implements FromCollection{
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
