<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Tag;

class Lancamento extends Model
{
	protected $fillable = [
		'tag','descricao','tipo'
	];

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
		if(($lancamento->tipo != "D") && ($lancamento->tipo != "C")){
			 throw new \Exception("O tipo deve ser debito(d) ou credito(c).");
		}elseif(!$lancamento->save()){
			throw new \Exception("Erro ao cadastrar lancamento.");
		}else{
			//salva primeiro as tags e depois as vincula no lancamento
			if(!is_null($tags)){

				foreach ($tags as $tag) {
					$newTag = new Tag();
					$newTag->descricao = $tag;
					$newTag->saveTag($newTag);
				}
			}
			$lancamento->save();
		}
	}
	//vincula tags ao lançamento
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
	public function giveLowLancamento($id){
		$lancamento = $this->verifyIfExists($id);
		$lancamento->status = 1;
		if($lancamento->tipo == "D"){
			$lancamento->tipo = "P";
		}elseif($lancamento->tipo == "C"){
			$lancamento->tipo = "R";
		}
		$lancamento->update();
	}

}
