<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;
use App\Http\Requests\StorePersonRequest;
use App\Http\Requests\UpdatePersonRequest;


class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $person = Person::paginate(8);
        return view('pessoas.index', compact('person'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pessoas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePersonRequest $request)
    {

        $arquivosNovosSalvos = [];

        try {
            DB::transaction(function () use ($request, &$arquivosNovosSalvos) {

                $person = Person::create([
                    'cpf' => $request->cpf,
                    'nome' => $request->nome,
                    'data_nascimento' => $request->data_nascimento,
                    'biografia' => $request->biografia,
                    'genero' => $request->genero,
                    'nacionalidade' => $request->nacionalidade,
                ]);

                $funcoes = $request->input('funcoes', []);

                if (in_array('ator', $funcoes)) {
                    $person->actor()->create();
                }
                if (in_array('diretor', $funcoes)) {
                    $person->director()->create();
                }
                if (in_array('escritor', $funcoes)) {
                    $person->writer()->create();
                }
                if (in_array('produtor', $funcoes)) {
                    $person->producer()->create();
                }

                if ($request->hasFile('imagens')) {
                    foreach ($request->file('imagens') as $arquivo) {

                        $caminho = $arquivo->store('pessoas', 'public');
                        $arquivosNovosSalvos[] = $caminho;

                        $novaImagem = Image::create([
                            'caminho' => $caminho,
                            'nome' => $arquivo->getClientOriginalName()
                        ]);

                        $person->image()->attach($novaImagem->id);
                    }
                }
            });

            return redirect()->route('pessoas.index')->with('sucesso', 'Pessoa cadastrada com sucesso com suas fotos!');

        } catch (\Exception $e) {
            foreach ($arquivosNovosSalvos as $caminho) {
                Storage::disk('public')->delete($caminho);
            }

            return back()->withInput()->withErrors(['funcoes' => 'Erro ao salvar o registro. Tente novamente. Erro: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $person = Person::findOrFail($id);
        return view('pessoas.show', compact('person'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $person = Person::findOrFail($id);
        return view('pessoas.edit', compact('person'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePersonRequest $request, string $id)
    {
        $person = Person::findOrFail($id);

        $arquivosNovosSalvos = [];

        try {
            DB::transaction(function () use ($request, $person, &$arquivosNovosSalvos) {

                $person->update($request->only(['cpf', 'nome', 'data_nascimento', 'biografia', 'genero', 'nacionalidade']));

                $funcoesSelecionadas = $request->input('funcoes', []);

                if (in_array('ator', $funcoesSelecionadas)) {
                    if (!$person->actor) {
                        $person->actor()->create();
                    }
                } else {
                    if ($person->actor) {
                        $person->actor()->delete();
                    }
                }

                if (in_array('diretor', $funcoesSelecionadas)) {
                    if (!$person->director) {
                        $person->director()->create();
                    }
                } else {
                    if ($person->director) {
                        $person->director()->delete();
                    }
                }

                if (in_array('escritor', $funcoesSelecionadas)) {
                    if (!$person->writer) {
                        $person->writer()->create();
                    }
                } else {
                    if ($person->writer) {
                        $person->writer()->delete();
                    }
                }

                if (in_array('produtor', $funcoesSelecionadas)) {
                    if (!$person->producer) {
                        $person->producer()->create();
                    }
                } else {
                    if ($person->producer) {
                        $person->producer()->delete();
                    }
                }

                if ($request->has('remover_imagens') && is_array($request->remover_imagens)) {
                    foreach ($request->remover_imagens as $imageId) {

                        $imagem = Image::find($imageId);

                        if ($imagem) {
                            if (Storage::disk('public')->exists($imagem->caminho)) {
                                Storage::disk('public')->delete($imagem->caminho);
                            }

                            $person->image()->detach($imageId);

                            $imagem->delete();
                        }
                    }
                }

                if ($request->hasFile('imagens')) {
                    foreach ($request->file('imagens') as $arquivo) {

                        $caminho = $arquivo->store('pessoas', 'public');
                        $arquivosNovosSalvos[] = $caminho;

                        $novaImagem = Image::create([
                            'caminho' => $caminho,
                            'nome' => $arquivo->getClientOriginalName()
                        ]);

                        $person->image()->attach($novaImagem->id);
                    }
                }
            });

            return redirect()->route('pessoas.index')->with('sucesso', 'Registro atualizado com sucesso!');

        } catch (\Exception $e) {
            foreach ($arquivosNovosSalvos as $caminho) {
                Storage::disk('public')->delete($caminho);
            }

            return back()->withInput()->withErrors(['funcoes' => 'Erro ao atualizar. ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $person = Person::findOrFail($id);

        try {
            DB::transaction(function () use ($person) {
                foreach ($person->image as $imagem) {
                    Storage::disk('public')->delete($imagem->caminho);
                    $imagem->delete();
                }

                $person->image()->detach();

                $person->delete();
            });

            return redirect()->route('pessoas.index')->with('sucesso', 'Pessoa e suas respectivas imagens foram removidas!');

        } catch (\Exception $e) {
            return redirect()->route('pessoas.index')->with('erro', 'Erro ao tentar remover a pessoa.');
        }
    }

    public function buscar(Request $request)
    {
        $termo = trim($request->input('q', ''));
        $movieId = $request->input('movie_id');

        if (strlen($termo) < 2) {
            return response()->json([]);
        }

        $persons = Person::where('nome', 'ilike', "%{$termo}%")
            ->limit(8)
            ->get();

        $movie = $movieId ? Movie::find($movieId) : null;

        return response()->json($persons->map(function ($person) use ($movie) {
            $vinculos = [];

            if ($movie) {
                if ($movie->actors()->whereHas('person', fn($q) => $q->where('people.id', $person->id))->exists()) {
                    $vinculos[] = 'ator';
                }
                if ($movie->directors()->whereHas('person', fn($q) => $q->where('people.id', $person->id))->exists()) {
                    $vinculos[] = 'diretor';
                }
                if ($movie->writers()->whereHas('person', fn($q) => $q->where('people.id', $person->id))->exists()) {
                    $vinculos[] = 'escritor';
                }
                if ($movie->producers()->whereHas('person', fn($q) => $q->where('people.id', $person->id))->exists()) {
                    $vinculos[] = 'produtor';
                }
            }

            return [
                'id' => $person->id,
                'nome' => $person->nome,
                'vinculos' => $vinculos,
            ];
        }));
    }


}
