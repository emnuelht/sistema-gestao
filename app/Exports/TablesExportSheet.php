<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TablesExportSheet implements WithMultipleSheets
{
    public function sheets(): array {
        return [
            new GruposExport(),
            new BandeirasExport(),
            new UnidadesExport(),
            new ColaboradoresExport(),
        ];
    }
}
