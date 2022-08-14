<?php

namespace App\Exports\GestionDechet;

use App\Models\Commande_dechet;
use Maatwebsite\Excel\Concerns\FromCollection;

class Commande_dechetExport implements FromCollection{
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
