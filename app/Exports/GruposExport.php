<?php

namespace App\Exports;

use App\Models\GrupoEconomico;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class GruposExport implements FromCollection, WithHeadings, WithTitle, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return GrupoEconomico::get();
    }

    public function map($grupo): array
    {
        return [
            $grupo->id,
            $grupo->nome,
            $grupo->created_at?->format('d/m/Y H:i:s'),
            $grupo->updated_at?->format('d/m/Y H:i:s'),
        ];
    }

    public function headings(): array
    {
        return ['ID', 'Nome', 'Criado em', 'Atualizado em'];
    }

    public function title(): string
    {
        return 'Grupos Econômicos'; // Nome da aba
    }
}
