<?php

namespace App\Http\Controllers;

use App\Models\HistoricosMateriais;
use Illuminate\Http\Request;
use App\Models\Materiais;
use App\Models\Produtos;
use App\Providers\DateHelpers;
use Illuminate\Support\Facades\DB;

class ProdutosController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $id = !empty($request->input('id')) ? ($request->input('id')) : ( !empty($id) ? $id : false );
        $nome = !empty($request->input('nome')) ? ($request->input('nome')) : ( !empty($nome) ? $nome : false );
        $descricao = !empty($request->input('descricao')) ? ($request->input('descricao')) : ( !empty($descricao) ? $descricao : false );
        $preco = !empty($request->input('preco')) ? ($request->input('preco')) : ( !empty($preco) ? $preco : false );
        
        $produtos = new Produtos();

        if ($id) {
        	$produtos =$produtos->where('id', '=', $id)->limit(10);
        }

        if (!empty($request->input('nome'))) {
        	$produtos = $produtos->where('nome', 'like', '%'.$request->input('nome').'%');
        }
        $produtos = Produtos::select('produtos.*', 'categorias.nome as nome_categoria','produtos.descricao')
        ->join('categorias', 'categorias.id', '=', 'produtos.categorias_id')
        //->where('produtos.id', '=', $id)
        ->limit(10)
        ->get();
        $tela = 'pesquisa';
    	$data = array(
				'tela' => $tela,
                'nome_tela' => 'produtos',
				'produtos'=> $produtos,
				'request' => $request,
				'rotaIncluir' => 'incluir-produtos',
				'rotaAlterar' => 'alterar-produtos'
			);
        return view('produtos', $data);
    }

     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function incluir(Request $request)
    {
        $metodo = $request->method();

    	if ($metodo == 'POST') {

    		$material_id = $this->salva($request);

	    	return redirect()->route('produtos', [ 'id' => $material_id ] );

    	}
        $tela = 'incluir';
    	$data = array(
				'tela' => $tela,
                'nome_tela' => 'produtos',
				'request' => $request,
				'rotaIncluir' => 'incluir-produtos',
				'rotaAlterar' => 'alterar-produtos'
			);

        return view('produtos', $data);
    }

    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */
    public function alterar(Request $request)
    {

        $produtos = new Produtos();

        $produtos= $produtos->where('id', '=', $request->input('id'))->get();

		$metodo = $request->method();
		if ($metodo == 'POST') {
    		$produtos_id = $this->salva($request, $produtos);
	    	return redirect()->route('produtos', [ 'id' => $produtos_id ] );

    	}

        $tela = 'alterar';
    	$data = array(
				'tela' => $tela,
                'nome_tela' => 'produtos',
				'produtos'=> $produtos,
				'request' => $request,
				'rotaIncluir' => 'incluir-produtos',
				'rotaAlterar' => 'alterar-produtos'
			);

        return view('produtos', $data);
    }
    public function salva($request, $historico = null) {

        $produtos = new Produtos();
        if(!empty($request->input('id'))) {
            $produtos = $produtos::find($request->input('id'));
        }
        $produtos->nome = $request->input('nome');
        $produtos->save();
        return $produtos->id;
    }
}
