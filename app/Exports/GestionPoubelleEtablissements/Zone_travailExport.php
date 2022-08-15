<?php

namespace App\Exports\GestionPoubelleEtablissements;

use App\Models\Zone_travail;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Zone_travailExport implements FromCollection ,WithHeadings{
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
        return collect(Zone_travail::getZoneTravail());
    }
}
