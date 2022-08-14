<?php

namespace App\Exports\TransportDechet;

use App\Models\Zone_depot;
use Maatwebsite\Excel\Concerns\FromCollection;

class Zone_depotExport implements FromCollection{
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
