<?php

namespace App\Exports\TransportDechet;

use App\Models\Camion;
use Maatwebsite\Excel\Concerns\FromCollection;

class CamionExport implements FromCollection{
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
