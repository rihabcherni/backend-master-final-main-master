<?php

namespace App\Exports;

use App\Http\Resources\ViderPoubelle;
use App\Models\Contact;
use App\Models\Vider_poubelle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ViderPoubelleExport implements FromCollection ,WithHeadings{
    public function headings():array{
        return[
            'id' ,

            'ID poubelle',
            'Nom poubelle',
            'Type poubelle',
            'Taux remplissage lors de vider poubelle' ,

            "Bloc_poubelle",
            "Etage",
            "Bloc etablissement",
            "Etablissement",

            'ID camion',
            'Matricule camion',

            'Date depot',
            'Quantité depose',
            "Crée le",
            "Modifié le",
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect(Vider_poubelle::getViderPoubelle());
    }
}
