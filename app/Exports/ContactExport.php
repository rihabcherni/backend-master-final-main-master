<?php

namespace App\Exports;

use App\Models\Contact;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ContactExport implements FromCollection ,WithHeadings{
    public function headings():array{
        return[
            "ID",
            "Nom",
            "Prenom",
            "E-mail",
            "Numero telephone",
            "Message",
            "Crée le",
            "Modifié le",
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect(Contact::getContact());
    }
}
