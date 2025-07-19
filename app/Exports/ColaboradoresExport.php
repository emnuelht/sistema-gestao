<?php

namespace App\Exports;

use App\Models\Colaborador;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class ColaboradoresExport implements FromCollection, WithHeadings, WithTitle, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Colaborador::with('unidade')->get();
    }

    public function map($colaborador): array
    {
        return [
            $colaborador->id,
            $colaborador->nome,
            $colaborador->email,
            $colaborador->cpf,
            $colaborador->unidade->nome,
            $colaborador->created_at?->format('d/m/Y H:i:s'),
            $colaborador->updated_at?->format('d/m/Y H:i:s'),
        ];
    }

    public function headings(): array
    {
        return ['ID', 'Nome', 'Email', 'CPF', 'Unidade', 'Criado em', 'Atualizado em'];
    }

    public function title(): string
    {
        return 'Colaboradores';
    }
}
