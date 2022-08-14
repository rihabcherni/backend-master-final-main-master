<?php

namespace App\Exports\ProductionPoubelle;

use App\Models\Stock_poubelle;
use Maatwebsite\Excel\Concerns\FromCollection;

class Stock_poubelleExport implements FromCollection{
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
