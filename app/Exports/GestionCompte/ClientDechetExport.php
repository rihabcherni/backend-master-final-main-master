<?php

namespace App\Exports\GestionCompte;

use App\Models\Client_dechet;
use Maatwebsite\Excel\Concerns\FromCollection;

class ClientDechetExport implements FromCollection
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
        return collect(Client_dechet::getClientDechet());
    }
}
