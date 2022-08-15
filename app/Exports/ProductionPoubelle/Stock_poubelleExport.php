<?php

namespace App\Exports\ProductionPoubelle;

use App\Models\Stock_poubelle;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class Stock_poubelleExport implements FromCollection , WithHeadings{
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
        return collect(Stock_poubelle::getStockPoubelle());
    }
}
