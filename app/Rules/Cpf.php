<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Cpf implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $cpf = preg_replace('/\D/', '', $value);

        if (strlen($cpf) != 11 || !$this->validarCpf($cpf)) {
            $fail('O campo deve conter um CPF válido e completo.');
        }
    }

    private function validarCpf($cpf)
    {
        // Verifica se todos os dígitos são iguais (ex: 111.111.111-11)
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Validação dos dígitos verificadores
        for ($t = 9; $t < 11; $t++) {
            $soma = 0;
            for ($c = 0; $c < $t; $c++) {
                $soma += $cpf[$c] * (($t + 1) - $c);
            }

            $digito = ($soma * 10) % 11;
            if ($digito == 10) {
                $digito = 0;
            }

            if ($cpf[$t] != $digito) {
                return false;
            }
        }

        return true;
    }
}
