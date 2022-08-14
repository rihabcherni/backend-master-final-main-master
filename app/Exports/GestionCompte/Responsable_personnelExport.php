<?php

namespace App\Exports\GestionCompte;

use App\Models\Responsable_personnel;
use Maatwebsite\Excel\Concerns\FromCollection;

class Responsable_personnelExport implements FromCollection
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
