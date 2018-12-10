<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Tag;

class Lancamento extends Model
{
	protected $fillable = [
		'tag','descricao','tipo','status','data_vencimento','valor'
	];

	//Esse método verifica o tipo do lancamento. Vai ser usado no método de cadastrar e alterar lancamento com o intuito de reaproveitar o código.
	public function verifyTypeLancamento($lancamentoTipo){
		if(($lancamentoTipo != "D") && ($lancamentoTipo != "C")){
			throw new \Exception("O tipo deve ser debito(D) ou credito(C).");
		}
	}
	//Faz a relacao many to many para tags
	public function tags(){
		return $this->belongsToMany('App\Tag');
	}

	//esse método verifica se existe o registro com base no ID. Vai servir para verificações em outros métodos e tem o objetivo de fazer reaproveitamento de código
	public function verifyIfExists($id){
		if(!$this->find($id)){
			throw new \Exception('Lancamento nao encontrado.');
		}else{
			return $this->find($id);
		}
	}


	public function saveLancamento(Lancamento $lancamento, $tags){
		$this->verifyTypeLancamento($lancamento->tipo);
		$lancamento->save();

		if(!$lancamento->save()){
			throw new \Exception("Erro ao cadastrar lancamento.");
		}else{
			//salva primeiro as tags e depois as vincula no lancamento
			if(!is_null($tags)){
				if(is_array($tags)){
					foreach ($tags as $tag) {
						$newTag = new Tag();
						$newTag->descricao = $tag;
						$newTag->saveTag($newTag);
						$lancamento->tags()->attach($newTag);
					}
				}else{
					$newTag = new Tag();
					$newTag->descricao = $tags;
					$newTag->saveTag($newTag);
					$lancamento->tags()->attach($newTag);
				}				
			}
		}
	}
	//vincula tags ao lançamento após o lancamento estar cadastrado
	public function bindTags($tags, $idLancamento){
		$lancamento = $this->find($idLancamento);
		return $lancamento->tags()->attach($tags);
	}

	public function list($id){
		$lancamento = $this->verifyIfExists($id);
		$lancamento->tags;
		return $lancamento;
	}
	public function listAll(){
		if(!$this->all()){
			throw new \Exception('Erro ao listar lancamento.');
		}elseif($this->all()->isEmpty()){
			throw new ModelNotFoundException('Nenhum lancamento encontrado.');
		}else{
			$lancamentos = $this->all();
			foreach ($lancamentos as $lancamento) {
				$lancamento->tags = $lancamento->tags;
			}
			return $lancamentos;
		}
	}
	public function updateLancamento($params, $id){
		$lancamento = $this->verifyIfExists($id);
		$this->verifyTypeLancamento($params['tipo']);
		if(!$lancamento->update($params)){
			throw new \Exception('Erro ao alterar lancamento.');
		}else{
			$lancamento->update($params);
		}
	}
	public function deleteLancamento($id){
		$lancamento = $this->verifyIfExists($id);
		if(!$lancamento->delete()){
			throw new \Exception('Erro ao excluir lancamento.');
		}else{
			$lancamento->delete();
		}
	}
	//Dá a baixa no lançamento. Faz as verificações se o lancamento existe, se a baixa já foi realizada. Caso passe por isso, dá a baixa. 
	public function giveLowLancamento($id){
		$lancamento = $this->verifyIfExists($id);
		if($lancamento->status==1){
			throw new \Exception('Baixa já realizada.');
		}
		$lancamento->status = 1;
		if($lancamento->tipo == "D"){
			$lancamento->tipo = "P";
		}elseif($lancamento->tipo == "C"){
			$lancamento->tipo = "R";
		}
		$lancamento->update();
	}


}
