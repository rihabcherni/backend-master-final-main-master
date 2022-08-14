<?php

namespace App\Exports\GestionCompte;

use App\Models\Ouvrier;
use Maatwebsite\Excel\Concerns\FromCollection;

class OuvrierExport implements FromCollection
{
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
        return collect(Gestionnaire::getOuv());
    }
}
