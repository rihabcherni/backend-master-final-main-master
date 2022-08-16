<?php

namespace App\Exports\TransportDechet;

use App\Models\Zone_depot;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Zone_depotExport implements FromCollection,WithHeadings{
    public function headings():array{
        return[
            "ID",
            "Zone travail",
            "Adresse",
            "Longitude",
            "Latitude",
            "Quantite depot maximale",
            "Quantite depot actuelle plastique",
            "Quantite depot actuelle papier",
            "Quantite depot actuelle composte",
            "Quantite depot actuelle canette",
            "Crée le",
            "Modifié le",
        ];
    }

    public function collection()
    {
        return collect(Zone_depot::getZoneDepot());
    }
}
