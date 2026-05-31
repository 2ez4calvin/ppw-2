<?php

namespace App\Http\Controllers;

use App\Models\Studio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;

class StudioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $studios = Studio::paginate(8);
        return view('estudios.index', compact('studios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('estudios.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:45|unique:studios,nome',
            'local' => 'required|string|max:45',
            'imagens' => 'nullable|array',
            'imagens.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $arquivosSalvos = [];

        try {
            DB::transaction(function () use ($request, &$arquivosSalvos) {
                
                // Cria o Estúdio
                $studio = Studio::create([
                    'nome' => $request->nome, 
                    'local' => $request->local
                ]);

                if ($request->hasFile('imagens')) {
                    foreach ($request->file('imagens') as $arquivo) {
                        
                        $caminho = $arquivo->store('studios', 'public');
                        $arquivosSalvos[] = $caminho;

                        $novaImagem = Image::create([
                            'caminho' => $caminho,
                            'nome' => $arquivo->getClientOriginalName()
                        ]);

                        // Cria o vínculo na tabela pivot 'studio_image' 
                        $studio->image()->attach($novaImagem->id);
                    }
                }
            });

            return redirect()->route('estudios.index')->with('sucesso', 'Estúdio criado com sucesso!');

        } catch (\Exception $e) {
            // Remoção de arquivos caso haja falha
            foreach ($arquivosSalvos as $caminho) {
                Storage::disk('public')->delete($caminho);
            }

            return back()->withInput()->withErrors(['imagens' => 'Falha ao salvar o estúdio. O upload foi revertido. Erro: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $studio = Studio::findOrFail($id);
        return view('estudios.show', compact('studio'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $studio = Studio::findOrFail($id);
        return view('estudios.edit', compact('studio'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $studio = Studio::findOrFail($id);

        $request->validate([
            'nome' => 'required|string|max:45|unique:studios,nome,' . $studio->id,
            'local' => 'required|string|max:45',
            'remover_imagens' => 'nullable|array',
            'remover_imagens.*' => 'exists:images,id', // Verifica se o ID da imagem realmente existe
            'imagens' => 'nullable|array',
            'imagens.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $arquivosNovosSalvos = [];

        try {
            DB::transaction(function () use ($request, $studio, &$arquivosNovosSalvos) {
                
                // Atualiza os dados de texto do Estúdio
                $studio->update([
                    'nome' => $request->nome,
                    'local' => $request->local
                ]);

                //PRocessamento das iamgens
                if ($request->has('remover_imagens') && is_array($request->remover_imagens)) {
                    foreach ($request->remover_imagens as $imageId) {
                        
                        $imagem = Image::find($imageId);
                        
                        if ($imagem) {
                            if (Storage::disk('public')->exists($imagem->caminho)) {
                                Storage::disk('public')->delete($imagem->caminho);
                            }
                            
                            $studio->image()->detach($imageId);
                            
                            $imagem->delete();
                        }
                    }
                }

                if ($request->hasFile('imagens')) {
                    foreach ($request->file('imagens') as $arquivo) {
                        
                        $caminho = $arquivo->store('studios', 'public');
                        $arquivosNovosSalvos[] = $caminho; 

                        $novaImagem = Image::create([
                            'caminho' => $caminho,
                            'nome' => $arquivo->getClientOriginalName()
                        ]);

                        $studio->image()->attach($novaImagem->id);
                    }
                }
            });

            return redirect()->route('estudios.index')->with('sucesso', 'Estúdio atualizado com sucesso!');

        } catch (\Exception $e) {
            foreach ($arquivosNovosSalvos as $caminho) {
                Storage::disk('public')->delete($caminho);
            }
            return back()->withInput()->withErrors(['imagens' => 'Falha ao atualizar. Erro: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $studio = Studio::findOrFail($id);

        try {
            DB::transaction(function () use ($studio) {
                // 4. Limpeza no destroy: loop para excluir arquivos físicos e lógicos (Regra 4 da Aula 9)
                foreach ($studio->image as $imagem) {
                    // Remove o arquivo físico da pasta storage
                    Storage::disk('public')->delete($imagem->caminho);
                    // Remove o registro da tabela 'images'
                    $imagem->delete();
                }

                // Remove os vínculos da tabela pivot
                $studio->image()->detach();
                
                // Exclui o estúdio
                $studio->delete();
            });

            return redirect()->route('estudios.index')->with('sucesso', 'Estúdio e suas respectivas imagens foram removidos!');

        } catch (\Exception $e) {
            return redirect()->route('estudios.index')->with('erro', 'Erro ao tentar remover o estúdio.');
        }
    }
}
