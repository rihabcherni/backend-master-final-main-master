<?php

namespace App\Exports\ProductionPoubelle;

use App\Models\Fournisseur;
use Maatwebsite\Excel\Concerns\FromCollection;

class FournisseurExport implements FromCollection{
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
