<?php

namespace App\Exports\GestionPoubelleEtablissements;

use App\Models\Poubelle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PoubelleExport implements FromCollection, WithHeadings
{
    public function headings():array{
        return[
            "ID",
            "Id poubelle dans cette établissement",

            "Etablissement",
            "Id établissement",

            "Nom poubelle",
            "Nom poubelle dans cette établissement",
            'Type',
            "Etat",
            "Quantité collecté",

            "Bloc poubelle id",
            "Bloc poubelle id dans cette établissement",

            "Nom Bloc établissement",
            "Id Bloc établissement",
            "Etage",
            "Id étage",

            "Qrcode",

            "Crée le",
            "Modifié le",
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return Poubelle::all();
        return collect(Poubelle::getPoubelle());
    }
}
