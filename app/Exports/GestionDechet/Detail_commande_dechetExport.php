<?php

namespace App\Exports\GestionDechet;

use App\Models\Detail_commande_dechet;
use Maatwebsite\Excel\Concerns\FromCollection;

class Detail_commande_dechetExport implements FromCollection
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
