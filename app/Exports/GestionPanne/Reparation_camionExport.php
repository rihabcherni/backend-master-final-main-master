<?php

namespace App\Exports\GestionPanne;

use App\Models\Reparation_camion;
use Maatwebsite\Excel\Concerns\FromCollection;

class Reparation_camionExport implements FromCollection{
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
