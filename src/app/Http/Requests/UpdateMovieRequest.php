<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMovieRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
{
    return [
        'nome' => ['required', 'string', 'max:255'],
        'duracao' => ['required', 'integer'],
        'data_lancamento' => ['required', 'date'],
        'classificacao' => ['nullable', 'string'],
        'sinopse' => ['nullable', 'string'],
        'studio_id' => ['required', 'exists:studios,id'],
        'genres' => ['required', 'array'],
        'genres.*' => ['exists:genres,id'],
        'vinculos' => ['nullable', 'array'],
        'vinculos.*.person_id' => ['required_with:vinculos.*.tipo', 'exists:people,id'],
        'vinculos.*.tipo' => ['required_with:vinculos.*.person_id', 'in:ator,diretor,escritor,produtor'],
        'vinculos.*.papel' => ['nullable', 'string', 'max:255'],
        'remover_vinculos' => ['nullable', 'array'],
        'atores_existentes' => ['nullable', 'array'],
        'atores_existentes.*.papel' => ['nullable', 'string', 'max:255'],
        'imagens' => ['nullable', 'array'],
        'imagens.*' => ['image', 'max:2048'],
        'remover_imagens' => ['nullable', 'array'],
    ];
}
}
