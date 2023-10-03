<?php

namespace App\Http\Controllers;

use App\Models\Atividade;
use Illuminate\Http\Request;

class AtividadeController extends Controller {
    
    private $path = "fotos/atividades";

    public function index() {
        $data = Atividade::orderBy('data')->get();
        return view('atividade.index', compact('data'));
    }

    public function create() {
        return view('atividade.create');
    }

    public function store(Request $request) {
        // php artisan storage:link
        // Colocar os arquivos de imagem dentro da pasta "/storage/app/public"

        $regras = [
            'nome' => 'required|max:100|min:10',
            'descricao' => 'required|max:500|min:20',
            'data' => 'required',
            'foto' => 'required'
        ];

        $msgs = [
            "required" => "O preenchimento do campo [:attribute] é obrigatório!",
            "max" => "O campo [:attribute] possui tamanho máximo de [:max] caracteres!",
            "min" => "O campo [:attribute] possui tamanho mínimo de [:min] caracteres!",
        ];

        $request->validate($regras, $msgs);

        if($request->hasFile('foto')) {

            // Insert no Banco
            $reg = new Atividade();
            $reg->nome = $request->nome;
            $reg->descricao = $request->descricao;
            $reg->data = $request->data;
            $reg->save();    

            // Upload da Foto
            $id = $reg->id;
            $extensao_arq = $request->file('foto')->getClientOriginalExtension();
            $nome_arq = $id.'_'.time().'.'.$extensao_arq;
            $request->file('foto')->storeAs("public/$this->path", $nome_arq);
            $reg->foto = $this->path."/".$nome_arq;
            $reg->save();
        }
        
        return redirect()->route('atividade.index');
    }

    public function show($id) {
        
    }

    public function edit($id) {
        $dados = Atividade::find($id);

        if(!isset($dados)) { return "<h1>ID: $id não encontrado!</h1>"; }

        return view('atividade.edit', compact('dados'));
    }

    public function update(Request $request, $id) {
        $obj = Atividade::find($id);

        if(!isset($obj)) { return "<h1>ID: $id não encontrado!"; }


        // Atualiza Dados
        $obj->nome = $request->nome;
        $obj->descricao = $request->descricao;
        $obj->data = $request->data;
        // Upload da Foto
        $extensao_arq = $request->file('foto')->getClientOriginalExtension();
        $nome_arq = $id.'_'.time().'.'.$extensao_arq;
        $request->file('foto')->storeAs("public/$this->path", $nome_arq);
        $obj->foto = $this->path."/".$nome_arq;
        $obj->save();

        return redirect()->route('atividade.index');
    }

    public function destroy($id) {
        $obj = Atividade::find($id);

        if(!isset($obj)) { return "<h1>ID: $id não encontrado!"; }

        $obj->destroy($id);

        return redirect()->route('atividade.index');
    }
}
