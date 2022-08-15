<?php

namespace App\Exports\GestionPanne;

use App\Models\Reparation_camion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Reparation_camionExport implements FromCollection ,WithHeadings{
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
        return collect(Reparation_camion::getReparationCamion());
    }
}
