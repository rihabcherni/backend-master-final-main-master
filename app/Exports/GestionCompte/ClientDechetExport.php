<?php

namespace App\Exports\GestionCompte;

use App\Models\Client_dechet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ClientDechetExport implements FromCollection , WithHeadings {
    public function headings():array{
        return[
            "ID",
            "Nom entreprise",
            "Matricule fiscale",
            "Nom",
            "Prenom",
            "Adresse",
            "Numero fixe",
            "Numéro telephone",
            "E-mail",
            "Cree le",
            "Modifie le",
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
