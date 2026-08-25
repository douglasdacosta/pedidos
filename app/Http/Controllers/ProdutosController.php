<?php

namespace App\Http\Controllers;

use App\Models\HistoricosMateriais;
use Illuminate\Http\Request;
use App\Models\Materiais;
use App\Models\Produtos;
use App\Providers\DateHelpers;
use Illuminate\Support\Facades\DB;
use Laravel\Sail\Console\PublishCommand;

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
        $produtos = DB::table('produtos')
        ->join('categorias', 'categorias.id', '=', 'produtos.categorias_id')
        ->select('produtos.*', 'categorias.nome as nome_categoria','produtos.descricao');

        if (!empty($request->input('id'))) {
        	$produtos = $produtos->where('produtos.id', '=', $request->input('id'));
        }

        if (!empty($request->input('nome'))) {
            dd('aqui');
        	$produtos = $produtos->where('produtos.nome', 'like', '%'.$request->input('nome').'%');
        }

        $produtos = $produtos->limit(20)->get();

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

    		$produto_id = $this->salva($request);

	    	return redirect()->route('produtos', [ 'id' => $produto_id ] );

    	}
        $tela = 'incluir';
    	$data = array(
				'tela' => $tela,
                'nome_tela' => 'produtos',
                'categorias' => (new CategoriasController)->getAllCategorias(),
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

        $produtos = $produtos->where('id', '=', $request->input('id'))->get();

		$metodo = $request->method();
		if ($metodo == 'POST') {
    		$produtos_id = $this->salva($request, $produtos);
	    	return redirect()->route('produtos', [ 'id' => $produtos_id ] );

    	}
        $tela = 'alterar';
    	$data = array(
				'tela' => $tela,
                'nome_tela' => 'produtos',
                'categorias' => (new CategoriasController)->getAllCategorias(),
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
        $produtos->descricao = $request->input('descricao');
        $produtos->categorias_id = $request->input('categorias_id');
        $produtos->fabricante = $request->input('fabricante');
        $produtos->codigo = $request->input('codigo');
        $produtos->unidade_medida = $request->input('unidade_medida');
        $produtos->precounitario = $request->input('precounitario') != '' ? DateHelpers::formatFloatValue($request->input('precounitario')) : null;
        $produtos->fat = $request->input('fat');
        $produtos->moeda = $request->input('moeda');
        $produtos->origempreco = $request->input('origempreco') != '' ? DateHelpers::formatFloatValue($request->input('origempreco')) : null;
        $produtos->totaladotado = $request->input('totaladotado') != '' ? DateHelpers::formatFloatValue($request->input('totaladotado')) : null;
        $produtos->percentualdesconto = $request->input('percentualdesconto');
        $produtos->sistema = $request->input('sistema');
        $produtos->status = $request->input('status');
        $produtos->save();
        return $produtos->id;
    }

    public function consultaProdutos(Request $request) {


        $produtos = DB::table('produtos')
            ->join('categorias', 'categorias.id', '=', 'produtos.categorias_id')
            ->select('produtos.*', 'categorias.nome as nome_categoria')
            ->where('produtos.id', '=', $request->input('produto'))
            ->where('produtos.status', '=', 'A')
            ->orderby('produtos.id')
            ->get();



        return $produtos[0];
    }

}
