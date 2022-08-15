<?php

namespace App\Exports\GestionDechet;

use App\Models\Dechet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DechetExport implements FromCollection ,WithHeadings{
    public function headings():array{
        return[
            "ID",
            "Type dechet",
            "Prix unitaire",
            "Pourcentage remise",
            "Photo",
            "Crée le",
            "Modifié le",
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect(Dechet::getDechet());
    }
}
