<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Illuminate\Http\Request;
use App\Models\Orcamentos;
use App\Models\Produtos;
use App\Models\TextoObservacaoExecucao;
use App\Models\TextoOrcamentos;
use App\Providers\DateHelpers;
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



        $orcamentos = new Orcamentos();

        $orcamentos = DB::table('orcamentos')
        ->join('status', 'orcamentos.status_id', '=', 'status.id')
        ->join('clientes', 'clientes.id', '=', 'orcamentos.cliente_id')
        ->select('orcamentos.id as orcamentos_id', 'orcamentos.created_at as data_gerado', 'clientes.id as cliente_id', 'clientes.nome_fantasia as nome_fantasia', 'status.nome as status_name')
        ->limit(20);

        if (!empty($request->input('id'))) {
        	$orcamentos = $orcamentos->where('orcamentos.id', '=', $request->input('id'));
        }

        if (!empty($request->input('orcamentos.status'))){
            $orcamentos = $orcamentos->where('orcamentos.status', '=', $request->input('status'));
        }

        if(!empty($request->input('created_at')) && !empty($request->input('created_at_fim') )) {
            $orcamentos = $orcamentos->whereBetween('orcamentos.created_at', [DateHelpers::formatDate_dmY($request->input('created_at')), DateHelpers::formatDate_dmY($request->input('created_at_fim'))]);
        }
        if(!empty($request->input('created_at')) && empty($request->input('created_at_fim') )) {
            $orcamentos = $orcamentos->where('orcamentos.created_at', '>=', DateHelpers::formatDate_dmY($request->input('created_at')));
        }
        if(empty($request->input('created_at')) && !empty($request->input('created_at_fim') )) {
            $orcamentos = $orcamentos->where('orcamentos.created_at', '<=', DateHelpers::formatDate_dmY($request->input('created_at_fim')));
        }


        $orcamentos = $orcamentos->get();
        // dd($orcamentos);
        $tela = 'pesquisa';
    	$data = array(
				'tela' => $tela,
                'nome_tela' => 'orçamentos',
				'orcamentos'=> $orcamentos,
                'produtos' => $this->getAllProdutos(),
                'status_orcamento' => (new StatusController)->getAllStatus(),
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
                'textos_orcamentos' => $this->getAllTextoObservacoes(),
                'textos_observacao_execucao' => $this->getAllTextoObservacoesExclusoes(),
                'status_orcamento' => (new StatusController)->getAllStatus(),
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

	    	return redirect()->route('orcamentos', [ 'id' => $orcamento_id ] );
    	}

        $orcamentos = new Orcamentos();

        $orcamento= $orcamentos->where('id', '=', $request->input('id'))->get();

        $jsonObj = json_decode($orcamento[0]['dados_json'], true);

        $jsonObj = json_decode($jsonObj['composicaoep'], true);

        $composicao = array_map(function($item){
            return array_map(function($innerItem){
                return json_decode($innerItem, true);
            }, $item);
        }, $jsonObj);

        $tela = 'alterar';
    	$data = array(
				'tela' => $tela,
                'nome_tela' => 'Orçamentos',
				'orcamentos'=> $orcamento,
				'composicao'=> $composicao,
                'clientes' => (new ClientesController)->getAllCliente(),
                'produtos' => $this->getAllProdutos(),
                'textos_orcamentos' => $this->getAllTextoObservacoes(),
                'textos_observacao_execucao' => $this->getAllTextoObservacoesExclusoes(),
                'status_orcamento' => (new StatusController)->getAllStatus(),
				'request' => $request,
				'rotaIncluir' => '',
				'rotaAlterar' => 'alterar-orcamentos',
			);

        return view('orcamentos', $data);
    }

    public function salva(Request  $request) {

        DB::transaction(function () use ($request) {

            $Orcamentos = new Orcamentos();
            // dd($request->input());
            if($request->input('id')) {
                $Orcamentos = $Orcamentos::find($request->input('id'));
            }

            $composicoes_orcamento = json_decode($request->input('composicoes'));
            $Orcamentos->cliente_id = $request->input('cliente_id');
            $Orcamentos->status_id = $request->input('status_id');
            $Orcamentos->texto_orcamento = $request->input('texto_orcamento');
            $Orcamentos->dados_json = json_encode($composicoes_orcamento);
            $Orcamentos->observacoes_exclusoes = $request->input('observacoes_exclusoes');
            $Orcamentos->prazo_execucao = $request->input('prazo_execucao');
            $Orcamentos->garantia = $request->input('garantia');
            $Orcamentos->exibir_valores_orcamento = $request->input('exibir_valores_orcamento');
            $Orcamentos->descricao_valores = $request->input('descricao_valores');
            $Orcamentos->condicoes_pagamentos = $request->input('condicoes_pagamentos');
            $Orcamentos->dados_bancarios_pagamento = $request->input('dados_bancarios_pagamento');
            $Orcamentos->status = $request->input('status');
            $Orcamentos->save();

            return $Orcamentos->id;
        });
    }

    public function consultaTextoExclusao(Request $request) {

        $id_texto = $request->input('id');
        $texto = $request->input('texto');

        $texto_novo =  $this->getAllTextoObservacoesExclusoesByID($id_texto);

        if(trim($texto) != '') {
            $texto_novo = trim($texto) . "\r\n" . $texto_novo[0]['texto_completo'];
        } else {
            $texto_novo = $texto_novo[0]['texto_completo'];
        }

        return response($texto_novo);
    }


    public function imprimir(Request $request)
    {

        $mes_extenso = array(
            '01' => 'Janeiro',
            '02' => 'Fevereiro',
            '03' => 'Marco',
            '04' => 'Abril',
            '05' => 'Maio',
            '06' => 'Junho',
            '07' => 'Julho',
            '08' => 'Agosto',
            '09' => 'Novembro',
            '10' => 'Setembro',
            '11' => 'Outubro',
            '12' => 'Dezembro'
        );

        $orcamentos = new Orcamentos();
        $clientes = new Clientes();

        $orcamentos = $orcamentos->where('id', '=', $request->input('id'))->get()->toarray();
        $clientes = $clientes->where('id','=',$orcamentos[0]['cliente_id'])->get();

        $clientes = $clientes[0];
        $imprimirPDF = new PDFController();

        $jsonObj = json_decode($orcamentos[0]['dados_json'], true);

        $jsonObj = json_decode($jsonObj['composicaoep'], true);

        $composicao = array_map(function($item){
            return array_map(function($innerItem){
                return json_decode($innerItem, true);
            }, $item);
        }, $jsonObj);


        $orcamentos = [
            'orcamentos' => $orcamentos[0],
            'composicao' => $composicao,
            'data_descricao' =>  "São Paulo, ".date('d'). ' de '. $mes_extenso[date('m')] . ' de ' .date('Y'),
            'responsavel' => "Ao " . $clientes->nome_fantasia ."\n ". $clientes->endereco . ", Nº ".$clientes->endereco. ", " . $clientes->cidade."/".$clientes->estado  ." \n A/c: $clientes->nome_responsavel"
        ];

        return $imprimirPDF->generatePDF($orcamentos, 'imprimir_orcamentos');

        // return view('imprimir_orcamentos', $orcamentos);

    }

    public function getAllProdutos() {
        $Produtos = new Produtos();
        return $Produtos->where('status', '=', 'A')->get();

    }
    public function getAllTextoObservacoesExclusoes() {
        $TextoObservacaoExecucao = new TextoObservacaoExecucao();
        return $TextoObservacaoExecucao->where('status', '=', 'A')->get();

    }

    public function getAllTextoObservacoesExclusoesByID($id) {
        $TextoObservacaoExecucao = new TextoObservacaoExecucao();
        $TextoObservacaoExecucao = $TextoObservacaoExecucao->where('id', '=', $id);
        return $TextoObservacaoExecucao->where('status', '=', 'A')->get();


    }

    public function getAllTextoObservacoes() {
        $TextoOrcamentos = new TextoOrcamentos();
        return $TextoOrcamentos->where('status', '=', 'A')->get();

    }

}
