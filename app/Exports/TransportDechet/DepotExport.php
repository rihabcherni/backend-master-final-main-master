<?php

namespace App\Exports\TransportDechet;

use App\Models\Depot;
use Maatwebsite\Excel\Concerns\FromCollection;

class DepotExport implements FromCollection{
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
