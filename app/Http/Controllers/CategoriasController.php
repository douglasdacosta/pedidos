<?php

namespace App\Http\Controllers;

use App\Models\Categorias;
use App\Models\HistoricosMateriais;
use Illuminate\Http\Request;
use App\Models\Materiais;
use App\Providers\DateHelpers;
use Illuminate\Support\Facades\DB;

class CategoriasController extends Controller
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

        $categorias = new Categorias();

        if ($id) {
        	$categorias =$categorias->where('id', '=', $id);
        }

        if (!empty($request->input('nome'))) {
        	$categorias = $categorias->where('nome', 'like', '%'.$request->input('nome').'%');
        }

        if (!empty($request->input('status'))){
            $categorias = $categorias = $categorias->where('status', '=', $request->input('status'));
        }
        $categorias = $categorias->get();
        
        $tela = 'pesquisa';
    	$data = array(
				'tela' => $tela,
                'nome_tela' => 'categorias',
				'categorias'=> $categorias,
				'request' => $request,
				'rotaIncluir' => 'incluir-categorias',
				'rotaAlterar' => 'alterar-categorias'
			);
        return view('categorias', $data);
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

	    	return redirect()->route('categorias', [ 'id' => $material_id ] );

    	}
        $tela = 'incluir';
    	$data = array(
				'tela' => $tela,
                'nome_tela' => 'categorias',
				'request' => $request,
				'rotaIncluir' => 'incluir-categorias',
				'rotaAlterar' => 'alterar-categorias'
			);

        return view('materiais', $data);
    }

     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function alterar(Request $request)
    {

        $categorias = new Categorias();
        $historico = '';

        $categorias= $categorias->where('id', '=', $request->input('id'))->get();

		$metodo = $request->method();
		if ($metodo == 'POST') {

            if($categorias[0]->valor != DateHelpers::formatFloatValue($request->input('valor'))) {
                DateHelpers::formatDate_dmY($request->input("data_entrega"));
                $historico = "Valor do material alterado  de ". number_format($categorias[0]->valor, 2, ',', '') . " para " . $request->input('valor');

            }
    		$categoria_id = $this->salva($request, $historico);

	    	return redirect()->route('categorias', [ 'id' => $categoria_id ] );

    	}
        $historicos = HistoricosMateriais::where('categorias_id','=', $categorias[0]->id)->get();

        $tela = 'alterar';
    	$data = array(
				'tela' => $tela,
                'nome_tela' => 'categorias',
				'categorias'=> $categorias,
				'request' => $request,
                'historicos'=> $historicos,
				'rotaIncluir' => 'incluir-categorias',
				'rotaAlterar' => 'alterar-categorias'
			);

        return view('categorias', $data);
    }

    public function salva($request, $historico = null) {

        $id = DB::transaction(function () use ($request, $historico) {

            $materiais = new Materiais();
            $tempo_torre = '00:00:00';
            if(!empty($request->input('tempo_montagem_torre'))) {
                $tempo_torre = '00:'.$request->input('tempo_montagem_torre');
            }

            if($request->input('id')) {
                $materiais = $materiais::find($request->input('id'));
            }
            $materiais->codigo = $request->input('codigo');
            $materiais->material = $request->input('material');
            $materiais->espessura = $request->input('espessura');
            $materiais->unidadex = $request->input('unidadex');
            $materiais->unidadey = $request->input('unidadey');
            $materiais->peca_padrao = $request->input('peca_padrao');
            $materiais->tempo_montagem_torre = $tempo_torre;
            $materiais->valor = DateHelpers::formatFloatValue($request->input('valor'));
            $materiais->status = $request->input('status');
            $materiais->save();

            if(!empty($historico)) {
                $historicos = new HistoricosMateriais();
                $historicos->materiais_id = $materiais->id;
                $historicos->historico = $historico;
                $historicos->status = 'A';
                $historicos->save();
            }

        return $materiais->id;
    });

    return $id;

}
}
