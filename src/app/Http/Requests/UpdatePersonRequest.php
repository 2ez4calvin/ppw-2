<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePersonRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
        'cpf' => 'required|string|max:45|unique:people,cpf,' . $this->person->id,
        'nome' => 'required|string|max:45',
        'data_nascimento' => 'required|date',
        'biografia' => 'nullable|string',
        'genero' => 'nullable|string|max:10',
        'nacionalidade' => 'nullable|string|max:45',
        'funcoes' => 'required|array|min:1',
        'funcoes.*' => 'in:ator,diretor,escritor,produtor',
        'remover_imagens' => 'nullable|array', // Validação pro array que vai remover imagens
        'remover_imagens.*' => 'exists:images,id',
        'imagens' => 'nullable|array',
        'imagens.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }
}
