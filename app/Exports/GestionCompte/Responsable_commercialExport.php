<?php

namespace App\Exports\GestionCompte;

use App\Models\Responsable_commercial;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Responsable_commercialExport implements FromCollection ,WithHeadings{
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
        return collect(Responsable_commercial::getResponsableCommercial());
    }
}
