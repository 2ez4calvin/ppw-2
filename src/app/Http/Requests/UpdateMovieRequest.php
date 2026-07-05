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
            'nome' => 'required|string|max:45',
            'data_lancamento' => 'required|date|',
            'duracao' => 'required|integer',
            'sinopse' => 'nullable|string',
            'classificacao' => 'nullable|string|max:45',
            'studio_id' => 'required|exists:studios,id',
            'genres' => 'required|array|min:1',
            'genres.*' => 'exists:genres,id',
            'directors' => 'required|array|min:1',
            'directors.*' => 'exists:directors,id',
            'actors' => 'nullable|array',
            'actors.*' => 'exists:actors,id',
            'writers' => 'nullable|array',
            'writers.*' => 'exists:writers,id',
            'producers' => 'nullable|array',
            'producers.*' => 'exists:producers,id',
            'remover_imagens' => 'nullable|array',
            'remover_imagens.*' => 'exists:images,id',
            'imagens' => 'nullable|array',
            'imagens.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',             
        ];
    }
}
