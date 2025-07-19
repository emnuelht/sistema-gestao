<?php

namespace App\Exports;

use App\Models\Unidade;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class UnidadesExport implements FromCollection, WithHeadings, WithTitle, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Unidade::with('bandeira')->get();
    }

    public function map($unidade): array
    {
        return [
            $unidade->id,
            $unidade->nome_fantasia,
            $unidade->razao_social,
            $unidade->cnpj,
            $unidade->bandeira->nome,
            $unidade->created_at?->format('d/m/Y H:i:s'),
            $unidade->updated_at?->format('d/m/Y H:i:s'),
        ];
    }

    public function headings(): array
    {
        return ['ID', 'Nome Fantasia', 'Razão Social', 'CNPJ', 'Bandeira', 'Criado em', 'Atualizado em'];
    }

    public function title(): string
    {
        return 'Unidades';
    }
}
