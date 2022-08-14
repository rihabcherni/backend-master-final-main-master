<?php

namespace App\Exports\GestionPanne;

use App\Models\Mecanicien;
use Maatwebsite\Excel\Concerns\FromCollection;

class MecanicienExport implements FromCollection{
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
