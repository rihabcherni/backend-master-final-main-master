<?php

namespace App\Exports\TransportDechet;

use App\Models\Depot;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DepotExport implements FromCollection ,WithHeadings{
    public function headings():array{
        return[
            "ID",
            "ID zone depot",
            "ID camion",
            "Date depot",
            "Quantite depose plastique",
            "Quantite depose papier",
            "Quantite depose composte",
            "Quantite depose canette",
            "Crée le",
            "Modifié le",
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect(Depot::getDepot());
    }
}
