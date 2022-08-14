<?php

namespace App\Exports\GestionDechet;

use App\Models\Dechet;
use Maatwebsite\Excel\Concerns\FromCollection;

class DechetExport implements FromCollection{
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
