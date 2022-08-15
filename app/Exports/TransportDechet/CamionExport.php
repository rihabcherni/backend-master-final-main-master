<?php

namespace App\Exports\TransportDechet;

use App\Models\Camion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CamionExport implements FromCollection, WithHeadings{
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
        return collect(Camion::getCamion());
    }
}
