<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStudioRequest extends FormRequest
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
            'nome' => 'required|string|max:45|unique:studios,nome,' . $this->studio->id,
            'local' => 'required|string|max:45',
            'remover_imagens' => 'nullable|array',
            'remover_imagens.*' => 'exists:images,id', // Verifica se o ID da imagem realmente existe
            'imagens' => 'nullable|array',
            'imagens.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }
}
