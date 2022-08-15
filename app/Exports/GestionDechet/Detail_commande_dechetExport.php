<?php

namespace App\Exports\GestionDechet;

use App\Models\Detail_commande_dechet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Detail_commande_dechetExport implements FromCollection ,WithHeadings{
    public function headings():array{
        return[
            "ID",
            "Numero commande dechet",
            "Type",
            "Quantite",
            "Crée le",
            "Modifié le",
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect(Detail_commande_dechet::getDetailCommandeDechet());
    }
}
