<?php

namespace App\Exports\GestionPanne;

use App\Models\Mecanicien;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MecanicienExport implements FromCollection ,WithHeadings{
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
        return collect(Mecanicien::getMecanicien());
    }
}
