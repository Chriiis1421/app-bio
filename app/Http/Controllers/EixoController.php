<?php

namespace App\Http\Controllers;

use App\Models\Eixo;
use Illuminate\Http\Request;

class EixoController extends Controller {
    
    private $path = "fotos/eixos";

    public function index() {
        $nome = Eixo::orderBy('nome')->get();
        return view('eixo.index', compact('nome'));
    }

    public function create() {
        return view('eixo.create');
    }

    public function store(Request $request) {
        // php artisan storage:link
        // Colocar os arquivos de imagem dentro da pasta "/storage/app/public"

        $regras = [
            'nome' => 'required|max:50|min:10'
        ];

        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
            "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
            "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!",
        ];

        $request->validate($regras, $msgs);
        
        return redirect()->route('eixo.index');
    }

    public function show($id) {
        
    }

    public function edit($id) {
        $dados = Eixo::find($id);

        if(!isset($dados)) { return "<h1>ID: $id não encontrado!</h1>"; }

        return view('eixo.edit', compact('dados'));
    }

    public function update(Request $request, $id) {
        $obj = Eixo::find($id);

        if(!isset($obj)) { return "<h1>ID: $id não encontrado!"; }

        // Atualiza Dados
        $obj->nome = $request->nome;

        return redirect()->route('eixo.index');
    }

    public function destroy($id) {
        $obj = Eixo::find($id);

        if(!isset($obj)) { return "<h1>ID: $id não encontrado!"; }

        $obj->destroy($id);

        return redirect()->route('eixo.index');
    }
}
