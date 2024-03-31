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

        $categorias= $categorias->where('id', '=', $request->input('id'))->get();

		$metodo = $request->method();
		if ($metodo == 'POST') {
    		$categoria_id = $this->salva($request, $categorias);
	    	return redirect()->route('categorias', [ 'id' => $categoria_id ] );

    	}

        $tela = 'alterar';
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

    public function salva($request, $historico = null) {

        $id = DB::transaction(function () use ($request, $historico) {

            $categorias = new Categorias();

            if(!empty($request->input('id'))) {
                $categorias = $categorias::find($request->input('id'));
            }
            $categorias->nome = $request->input('nome');
            $categorias->save();

        return $categorias->id;
    });

    return $id;

}
}
