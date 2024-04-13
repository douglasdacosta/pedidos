<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fichastecnicas;
use App\Models\Fichastecnicasitens;
use App\Models\Orcamentos;
use App\Models\Produtos;
use Illuminate\Support\Facades\DB;

class OrcamentosController extends Controller
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

        $orcamentos = new Orcamentos();

        if ($id) {
        	$orcamentos = $orcamentos->where('id', '=', $id);
        }

        if (!empty($request->input('status'))){
            $orcamentos = $orcamentos->where('status', '=', $request->input('status'));
        }

        $orcamentos = $orcamentos->get();
        $tela = 'pesquisa';
    	$data = array(
				'tela' => $tela,
                'nome_tela' => 'orçamentos',
				'orcamentos'=> $orcamentos,
                'produtos' => $this->getAllProdutos(),
				'request' => $request,
				'rotaIncluir' => 'incluir-orcamentos',
				'rotaAlterar' => 'alterar-orcamentos'
			);

        return view('orcamentos', $data);
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
    		$orcamentos_id = $this->salva($request);

	    	return redirect()->route('orcamentos', [ 'id' => $orcamentos_id ] );

    	}
        $tela = 'incluir';
    	$data = array(
				'tela' => $tela,
                'nome_tela' => 'orçamentos',
				'request' => $request,
                'clientes' => (new ClientesController)->getAllCliente(),
                'produtos' => $this->getAllProdutos(),
				'rotaIncluir' => 'incluir-orcamentos',
				'rotaAlterar' => 'alterar-orcamentos'
			);

        return view('orcamentos', $data);
    }

     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function alterar(Request $request)
    {
		$metodo = $request->method();

		if ($metodo == 'POST') {

    		$orcamento_id = $this->salva($request);

	    	return redirect()->route('orcamento', [ 'id' => $orcamento_id ] );
    	}

        $orcamentos = new Orcamentos();

        $orcamento= $orcamentos->where('id', '=', $request->input('id'))->get();

        $tela = 'alterar';
    	$data = array(
				'tela' => $tela,
                'nome_tela' => 'Orçamentos',
				'orcamentos'=> $orcamento,
                'produtos' => $this->getAllProdutos(),
				'request' => $request,
				'rotaIncluir' => '',
				'rotaAlterar' => 'alterar-orcamentos',
			);

        return view('orcamentos', $data);
    }

    public function salva(Request  $request) {

        DB::transaction(function () use ($request) {


        });
    }

/**
 * Transforma um numero inteiro em formato de 00:00:00
 */
    function trataStringHora($numeroString) {

        preg_match_all('/[0-9]/', $numeroString, $numerosEncontrados);

        $numerosString = $numerosEncontrados ? implode('', $numerosEncontrados[0]) : '';

        while (strlen($numerosString) < 6) {
            $numerosString = '0' . $numerosString;
        }
        $horaFormatada = substr($numerosString, 0, 2) . ':' . substr($numerosString, 2, 2) . ':' . substr($numerosString, 4, 2);

        return $horaFormatada;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getAllProdutos() {
        $Produtos = new Produtos();
        return $Produtos->where('status', '=', 'A')->get();

    }
}
