<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Lancamento;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LancamentoController extends Controller
{
	

    public function create(Request $request){
		try{
			$lancamento = new Lancamento();
			$lancamento->descricao = $request->input('descricao');
			$lancamento->data_vencimento = $request->input('data_vencimento');
			$lancamento->valor = $request->input('valor');
			$lancamento->tipo = $request->input('tipo');
			$lancamento->saveLancamento($lancamento, $request->input('tags'));
			//$lancamento->tags()->attach($request->input('idTags'));		
			return response()->json(['message-success'=>'Lancamento cadastrado com sucesso.']);
		}catch(\Exception $e){
			return response()->json(['message-error'=>$e->getMessage()]);
		}
	}
	//Vincula as tags já existentes a um lançamento já existente.
	public function bindTags(Request $request, $idLancamento){
		try{
			$lancamento = new Lancamento();	
			$lancamento->bindTags($request->idTags, $idLancamento);
			return response()->json(['message-success'=>'Tags vinculadas com sucesso.']);
		}catch(\Exception $e){
			return response()->json(['message-error'=>$e->getMessage()]);
		}
	}
	public function listOne($id){
		try{
			$lancamento = new Lancamento();
			$lancamento = $lancamento->list($id);
			return response()->json($lancamento);
		}catch(\Exception $e){
			return response()->json(['message-error'=>$e->getMessage()]);
		}
	}
	public function listAll(){
		try{
			$lancamento = new Lancamento();
			$lancamentos = $lancamento->listAll();
			return response()->json($lancamentos);
		}catch(ModelNotFoundException $me){
			return response()->json(['message-warning'=>$me->getMessage()]);
		}catch(\Exception $e){
			return response()->json(['message-error'=>$e->getMessage()]);
		}
	}
	public function update(Request $request, $id){
		try{
			$lancamento = new Lancamento();
			$lancamento->updateLancamento($request->all(), $id);
			return response()->json(['message-success'=>'Lancamento alterado com sucesso.']);
		}catch(\Exception $e){
			return response()->json(['message-error'=>$e->getMessage()]);
		}
	}
	public function delete($id){
		try{
			$lancamento = new Lancamento();
			$lancamento->deleteLancamento($id);
			return response()->json(['message-success'=>'Lancamento excluído com sucesso.']);
		}catch(\Exception $e){
			return response()->json(['message-error'=>$e->getMessage()]);
		}
	}

	//Faz o uso do método de baixa do lançamento
	public function giveLowLancamento($id){
		try{
			$lancamento = new Lancamento();
			$lancamento->giveLowLancamento($id);
			return response()->json(['message-success'=>'Baixa realizada com sucesso.']);
		}catch(\Exception $e){
			return response()->json(['message-error'=>$e->getMessage()]);
		}
	}
}
