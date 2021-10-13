<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiaristaRequest;
use App\Models\Diarista;
use App\Services\ViaCep;
use Illuminate\Http\Request;

class DiaristaController extends Controller
{

    protected ViaCep $viaCep;
    public function __construct(ViaCep $viaCep){
        $this->viaCep = $viaCep;
    }

    /**
     * Método responsável por renderizar a página inicial do e-diaristas que lista as diaristas
     */
    public function index(){
        
        $diaristas = Diarista::get();

        return view('diaristas.index', compact('diaristas'));
    }

    /**
     * Método responsável por renderizar o formulário de criação de um novo registro de diarista
     */
    public function create(){
        return view('diaristas.create');
    }

     /**
     * Método responsável por criar um novo registro no banco de dados
     */
    public function store(DiaristaRequest $request){
        
        $dados = $request->except('_token');
        $dados['foto_usuario'] = $request->foto_usuario->store('public');

        $dados['cpf'] = str_replace(['.', '-'], '', $dados['cpf']);
        $dados['cep'] = str_replace('-', '', $dados['cep']);
        $dados['telefone'] = str_replace(['(', ')', ' ','-'], '', $dados['telefone']);
        $dados['codigo_ibge'] = $this->viaCep->buscar($dados['cep'])['ibge'];

        Diarista::create($dados);

        return redirect()->route('diaristas.index');
    }

    /**
     * Método responsável por renderizar o formulário de edição de um registro de diarista
     */
    public function edit(int $id){

        $diarista = Diarista::findOrFail($id);

        return view('diaristas.edit', ['diarista' => $diarista]);
    }

    /**
     * Método responsável por editar um registro no banco de dados
     */
    public function update(int $id, DiaristaRequest $request){
        
        $diarista = Diarista::findOrFail($id);

        $dados = $request->except(['_token', '_method']);

        $dados['cpf'] = str_replace(['.', '-'], '', $dados['cpf']);
        $dados['cep'] = str_replace('-', '', $dados['cep']);
        $dados['telefone'] = str_replace(['(', ')', ' ','-'], '', $dados['telefone']);
        $dados['codigo_ibge'] = $this->viaCep->buscar($dados['cep'])['ibge'];

        if($request->hasFile('foto_usuario')){
            $dados['foto_usuario'] = $request->foto_usuario->store('public');
        }

        $diarista->update($dados);
        
        return redirect()->route('diaristas.index');
    }

    /**
     * Método responsável por destruir(apagar) um registro no banco de dados
     */
    public function destroy(int $id, Request $request){
        $diarista = Diarista::findOrFail($id);

        $diarista->delete();

        return redirect()->route('diaristas.index');
    }
}


