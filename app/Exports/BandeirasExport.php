<?php

namespace App\Exports;

use App\Models\Bandeira;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class BandeirasExport implements FromCollection, WithHeadings, WithTitle, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Bandeira::with('grupoEconomico')->get();
    }

    public function map($bandeira): array
    {
        return [
            $bandeira->id,
            $bandeira->nome,
            $bandeira->grupoEconomico->nome,
            $bandeira->created_at?->format('d/m/Y H:i:s'),
            $bandeira->updated_at?->format('d/m/Y H:i:s'),
        ];
    }


    public function headings(): array
    {
        return ['ID', 'Nome', 'Grupo Economico', 'Criado em', 'Atualizado em'];
    }

    public function title(): string
    {
        return 'Bandeiras';
    }
}
