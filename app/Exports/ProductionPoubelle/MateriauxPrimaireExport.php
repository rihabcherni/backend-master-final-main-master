<?php

namespace App\Exports\ProductionPoubelle;

use App\Models\MateriauxPrimaire;
use Maatwebsite\Excel\Concerns\FromCollection;

class MateriauxPrimaireExport implements FromCollection{
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
