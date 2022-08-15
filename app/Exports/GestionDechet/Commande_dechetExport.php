<?php

namespace App\Exports\GestionDechet;

use App\Models\Commande_dechet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Commande_dechetExport implements FromCollection ,WithHeadings{
    public function headings():array{
        return[
            "ID",
            "Matricule fiscale",
            "Entreprise",
            "Numero client dechet",
            "Montant total",
            "Date commande",
            "Date livraison",
            "Type paiment",
            "Crée le",
            "Modifié le",
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect(Commande_dechet::getCommandeDechet());
    }
}
