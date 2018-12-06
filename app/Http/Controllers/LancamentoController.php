<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lancamento;

class LancamentoController extends Controller
{
    public function create(Request $request){
		try{
			$lancamento = new Lancamento();
			$lancamento->descricao = $request->input('descricao');
			$lancamento->data_vencimento = $request->input('dataVencimento');
			$lancamento->valor = $request->input('valor');
			$lancamento->tipo = $request->input('tipo');
			$lancamento->status = $request->input('status');
			$lancamento->saveLancamento($lancamento);		
			return response()->json(['message-success'=>'Lancamento cadastrado com sucesso.']);
		}catch(\Exception $e){
			return response()->json(['message-error'=>$e->getMessage()]);
		}
	}
}
